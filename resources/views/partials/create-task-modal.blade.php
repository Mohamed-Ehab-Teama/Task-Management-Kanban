<div class="modal fade" id="newTaskModal" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="bi bi-plus-circle me-2"></i>Create New Task</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="newTaskForm">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">Task Title *</label>
                        <input type="text" class="form-control" id="taskTitle" required>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="taskDescription" rows="3"></textarea>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="taskPriority" class="form-label">Priority *</label>
                            <select class="form-select" id="taskPriority" required>
                                <option value="low">Low</option>
                                <option value="medium" selected>Medium</option>
                                <option value="high">High</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="taskDueDate" class="form-label">Due Date</label>
                            <input type="date" class="form-control" id="taskDueDate">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="taskStatus" class="form-label">Status *</label>
                            <select class="form-select" id="taskStatus" required>
                                <option value="backlog" selected>Backlog</option>
                                <option value="todo">To Do</option>
                                <option value="inprogress">In Progress</option>
                                <option value="review">Review</option>
                                <option value="done">Done</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="taskAssignee" class="form-label">Assignee</label>
                            <input type="text" class="form-control" id="taskAssignee" placeholder="Enter initials">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="taskTags" class="form-label">Tags (comma separated)</label>
                        <input type="text" class="form-control" id="taskTags" placeholder="e.g. Backend, Security, Bug">
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary-custom" onclick="createTask()">Create Task</button>
            </div>
        </div>
    </div>
</div>