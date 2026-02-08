<div class="toolbar">
    <div class="row g-3 align-items-center">
        <div class="col-md-4">
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" class="form-control" id="searchTasks" placeholder="Search tasks...">
            </div>
        </div>
        <div class="col-md-6">
            <div class="d-flex flex-wrap gap-2">
                <div class="filter-badge" data-filter="all">
                    <i class="bi bi-grid-3x3"></i> All Tasks
                </div>
                <div class="filter-badge" data-filter="assigned">
                    <i class="bi bi-person-check"></i> Assigned to Me
                </div>
                <div class="filter-badge" data-filter="overdue">
                    <i class="bi bi-exclamation-triangle"></i> Overdue
                </div>
                <div class="filter-badge" data-filter="today">
                    <i class="bi bi-calendar-check"></i> Due Today
                </div>
            </div>
        </div>
        <div class="col-md-2 text-end">
            <button class="btn btn-primary-custom" data-bs-toggle="modal" data-bs-target="#newTaskModal">
                <i class="bi bi-plus-circle me-2"></i>New Task
            </button>
        </div>
    </div>
</div>