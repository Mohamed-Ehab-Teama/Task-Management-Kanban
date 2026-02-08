/**
 * ============================================
 * Kanban Board – Drag & Drop Engine
 * ============================================
 */

class KanbanBoard {
    constructor() {
        this.draggedTask = null;
        this.sourceColumn = null;
        this.csrfToken = document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content');

        this.init();

        this.placeholder = document.createElement('div');
        this.placeholder.className = 'task-placeholder';
    }

    init() {
        this.initTasks();
        this.initColumns();
        this.updateAllCounts();
    }

    /**
     * -------------------------
     * Tasks (Draggable)
     * -------------------------
     */
    initTasks() {
        document.querySelectorAll('.task-card').forEach(task => {
            task.addEventListener('dragstart', e => this.onDragStart(e));
            task.addEventListener('dragend', e => this.onDragEnd(e));
        });
    }

    onDragStart(e) {
        this.draggedTask = e.target;
        this.sourceColumn = e.target.closest('.tasks-container');

        e.target.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
    }

    onDragEnd(e) {
        e.target.classList.remove('dragging');
        this.draggedTask = null;
        this.sourceColumn = null;
    }

    /**
     * -------------------------
     * Columns (Drop Zones)
     * -------------------------
     */
    initColumns() {
        document.querySelectorAll('.tasks-container').forEach(column => {
            column.addEventListener('dragover', e => this.onDragOver(e, column));
            column.addEventListener('drop', e => this.onDrop(e, column));
        });
    }

    onDragOver(e, column) {
        e.preventDefault();

        const afterElement = this.getDragAfterElement(column, e.clientY);
        // if (!afterElement) {
        //     column.appendChild(this.draggedTask);
        // } else {
        //     column.insertBefore(this.draggedTask, afterElement);
        // }
        if (!afterElement) {
            column.appendChild(this.placeholder);
        } else {
            column.insertBefore(this.placeholder, afterElement);
        }
    }

    async onDrop(e, targetColumn) {
        e.preventDefault();

        if (!this.placeholder.parentNode) return;

        const taskId = this.draggedTask.dataset.taskId;
        const newColumnId = this.extractColumnId(targetColumn.dataset.column);
        const newPosition =
            [...targetColumn.children].indexOf(this.placeholder) + 1;

        try {
            const response = await this.moveTask(
                taskId,
                newColumnId,
                newPosition
            );``

            // Remove placeholder
            this.placeholder.remove();

            // Apply DB order (single DOM write)
            this.applyColumnOrder(targetColumn, response.column_tasks);

            this.updateAllCounts();
        } catch (error) {
            this.placeholder.remove();
            alert(error.message);
        }
    }


    /**
     * -------------------------
     * API Calls
     * -------------------------
     */
    async moveTask(taskId, columnId, position) {
        const response = await fetch(`/tasks/${taskId}/move`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': this.csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                column_id: columnId,
                position: position
            })
        });

        if (!response.ok) {
            const data = await response.json();
            throw new Error(data.message || 'Failed to move task');
        }

        return response.json();
    }



    /**
     * -------------------------
     * Helpers
     * -------------------------
     */
    getDragAfterElement(container, y) {
        const draggableElements = [
            ...container.querySelectorAll('.task-card:not(.dragging)')
        ];

        return draggableElements.reduce(
            (closest, child) => {
                const box = child.getBoundingClientRect();
                const offset = y - box.top - box.height / 2;

                if (offset < 0 && offset > closest.offset) {
                    return { offset: offset, element: child };
                } else {
                    return closest;
                }
            },
            { offset: Number.NEGATIVE_INFINITY }
        ).element;
    }

    


    getTaskPosition(task, column) {
        const tasks = [...column.querySelectorAll('.task-card')];
        return tasks.indexOf(task) + 1;
    }


    extractColumnId(value) {
        // "column-5" → 5
        return parseInt(value.replace('column-', ''));
    }

    applyColumnOrder(columnEl, orderedTasks) {
        const taskMap = {};

        columnEl.querySelectorAll('.task-card').forEach(task => {
            taskMap[task.dataset.taskId] = task;
        });

        // Clear column
        columnEl.innerHTML = '';

        // Re-append in correct order
        orderedTasks.forEach(task => {
            if (taskMap[task.id]) {
                columnEl.appendChild(taskMap[task.id]);
            }
        });
    }


    updateAllCounts() {
        document.querySelectorAll('.kanban-column').forEach(column => {
            const count = column.querySelectorAll('.task-card').length;
            const badge = column.querySelector('.column-count');
            if (badge) badge.textContent = count;
        });
    }
}

/**
 * -------------------------
 * Boot
 * -------------------------
 */
document.addEventListener('DOMContentLoaded', () => {
    window.kanban = new KanbanBoard();
});
