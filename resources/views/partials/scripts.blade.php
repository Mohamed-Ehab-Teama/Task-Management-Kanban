<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom JavaScript -->
<script>
    // Drag and Drop Functionality
    // let draggedElement = null;

    // Make all task cards draggable
    document.addEventListener('DOMContentLoaded', function () {
        initializeDragAndDrop();
        updateColumnCounts();
        initializeSearch();
        initializeFilters();
    });

    function initializeDragAndDrop() {
        const taskCards = document.querySelectorAll('.task-card');
        const columns = document.querySelectorAll('.tasks-container');

        taskCards.forEach(card => {
            card.addEventListener('dragstart', handleDragStart);
            card.addEventListener('dragend', handleDragEnd);
        });

        columns.forEach(column => {
            column.addEventListener('dragover', handleDragOver);
            column.addEventListener('drop', handleDrop);
            column.addEventListener('dragleave', handleDragLeave);
        });
    }

    function handleDragStart(e) {
        draggedElement = this;
        this.classList.add('dragging');
        e.dataTransfer.effectAllowed = 'move';
        e.dataTransfer.setData('text/html', this.innerHTML);
    }

    function handleDragEnd(e) {
        this.classList.remove('dragging');
    }

    function handleDragOver(e) {
        if (e.preventDefault) {
            e.preventDefault();
        }
        e.dataTransfer.dropEffect = 'move';
        this.classList.add('drag-over');
        return false;
    }

    function handleDragLeave(e) {
        this.classList.remove('drag-over');
    }

    function handleDrop(e) {
        if (e.stopPropagation) {
            e.stopPropagation();
        }

        this.classList.remove('drag-over');

        if (draggedElement && draggedElement !== this) {
            this.appendChild(draggedElement);

            // Get the new status from the column
            const newStatus = this.getAttribute('data-column');
            console.log(`Task ${draggedElement.getAttribute('data-task-id')} moved to ${newStatus}`);

            // Update column counts
            updateColumnCounts();

            // Here you would typically make an AJAX call to update the backend
            // updateTaskStatus(draggedElement.getAttribute('data-task-id'), newStatus);
        }

        return false;
    }

    function updateColumnCounts() {
        const columns = document.querySelectorAll('.kanban-column');
        columns.forEach(column => {
            const count = column.querySelectorAll('.task-card').length;
            const countBadge = column.querySelector('.column-count');
            if (countBadge) {
                countBadge.textContent = count;
            }
        });
    }

    // Search Functionality
    function initializeSearch() {
        const searchInput = document.getElementById('searchTasks');
        searchInput.addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            const taskCards = document.querySelectorAll('.task-card');

            taskCards.forEach(card => {
                const title = card.querySelector('.task-title').textContent.toLowerCase();
                const description = card.querySelector('.task-description').textContent.toLowerCase();

                if (title.includes(searchTerm) || description.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    // Filter Functionality
    function initializeFilters() {
        const filterBadges = document.querySelectorAll('.filter-badge');
        filterBadges.forEach(badge => {
            badge.addEventListener('click', function () {
                // Remove active class from all badges
                filterBadges.forEach(b => b.classList.remove('active'));
                // Add active class to clicked badge
                this.classList.add('active');

                const filter = this.getAttribute('data-filter');
                applyFilter(filter);
            });
        });
    }

    function applyFilter(filter) {
        const taskCards = document.querySelectorAll('.task-card');
        const today = new Date().toISOString().split('T')[0];

        taskCards.forEach(card => {
            let show = true;

            switch (filter) {
                case 'all':
                    show = true;
                    break;
                case 'assigned':
                    // This would check if task is assigned to current user
                    // For demo, we'll show tasks assigned to "JD"
                    const assignee = card.querySelector('.task-assignee');
                    show = assignee && assignee.textContent === 'JD';
                    break;
                case 'overdue':
                    show = card.querySelector('.due-date.overdue') !== null;
                    break;
                case 'today':
                    const dueDate = card.querySelector('.due-date');
                    if (dueDate) {
                        const dateText = dueDate.textContent.trim();
                        show = dateText.includes('Feb 08'); // Today's date
                    }
                    break;
            }

            card.style.display = show ? 'block' : 'none';
        });
    }

    // Create New Task
    function createTask() {
        const title = document.getElementById('taskTitle').value;
        const description = document.getElementById('taskDescription').value;
        const priority = document.getElementById('taskPriority').value;
        const dueDate = document.getElementById('taskDueDate').value;
        const status = document.getElementById('taskStatus').value;
        const assignee = document.getElementById('taskAssignee').value || 'JD';
        const tags = document.getElementById('taskTags').value;

        if (!title) {
            alert('Please enter a task title');
            return;
        }

        // Create task card HTML
        const taskId = Date.now(); // Simple ID generation
        const tagsArray = tags.split(',').map(tag => tag.trim()).filter(tag => tag);
        const tagsHTML = tagsArray.map(tag => `<span class="task-tag">${tag}</span>`).join('');

        const dueDateFormatted = dueDate ? new Date(dueDate).toLocaleDateString('en-US', { month: 'short', day: 'numeric' }) : 'No date';

        const taskHTML = `
                <div class="task-card priority-${priority}" draggable="true" data-task-id="${taskId}">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="task-title">${title}</h6>
                        <span class="priority-badge priority-${priority}">${priority}</span>
                    </div>
                    <p class="task-description">${description || 'No description provided.'}</p>
                    ${tagsArray.length > 0 ? `<div class="task-tags">${tagsHTML}</div>` : ''}
                    <div class="task-footer">
                        <div class="task-meta">
                            <span class="due-date">
                                <i class="bi bi-calendar"></i>${dueDateFormatted}
                            </span>
                            <span><i class="bi bi-chat"></i>0</span>
                        </div>
                        <div class="task-assignee" title="${assignee}">${assignee}</div>
                    </div>
                </div>
            `;

        // Add to appropriate column
        const targetColumn = document.querySelector(`.tasks-container[data-column="${status}"]`);
        if (targetColumn) {
            targetColumn.insertAdjacentHTML('beforeend', taskHTML);

            // Reinitialize drag and drop for new card
            initializeDragAndDrop();
            updateColumnCounts();

            // Close modal and reset form
            const modal = bootstrap.Modal.getInstance(document.getElementById('newTaskModal'));
            modal.hide();
            document.getElementById('newTaskForm').reset();

            console.log('New task created:', { taskId, title, status });
        }
    }

    // Simulate real-time updates (for demo purposes)
    setInterval(function () {
        // This would be replaced with actual WebSocket or polling logic
        console.log('Checking for updates...');
    }, 30000);
</script>


{{-- Scripts Files --}}
<script src="{{ asset('assets/js/kanban-function.js') }}"></script>