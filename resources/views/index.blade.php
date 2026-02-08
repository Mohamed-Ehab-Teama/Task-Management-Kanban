<!DOCTYPE html>
<html lang="en">

@include('partials.head')

<body>
    <!-- Header -->
    @include('partials.header')



    <!-- Main Content -->
    <div class="container-fluid px-4">
        <!-- Toolbar -->
        @include('partials.toolbar')

        <!-- Kanban Board -->
        {{-- <div class="board-container" id="kanbanBoard">
            <!-- Backlog Column -->
            <div class="kanban-column" data-status="backlog">
                <div class="column-header">
                    <div class="column-title">
                        <span class="column-icon icon-backlog"></span>
                        Backlog
                        <span class="column-count">3</span>
                    </div>
                    <button class="btn btn-sm" title="Column Options">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
                <div class="tasks-container" data-column="backlog">
                    <div class="task-card priority-medium" draggable="true" data-task-id="1">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Implement user authentication module</h6>
                            <span class="priority-badge priority-medium">Medium</span>
                        </div>
                        <p class="task-description">Create JWT-based authentication with role management and password
                            recovery functionality.</p>
                        <div class="task-tags">
                            <span class="task-tag">Backend</span>
                            <span class="task-tag">Security</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar"></i>Feb 15
                                </span>
                                <span><i class="bi bi-paperclip"></i>2</span>
                                <span><i class="bi bi-chat"></i>5</span>
                            </div>
                            <div class="task-assignee" title="Sarah Miller">SM</div>
                        </div>
                    </div>

                    <div class="task-card priority-low" draggable="true" data-task-id="2">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Update documentation for API endpoints</h6>
                            <span class="priority-badge priority-low">Low</span>
                        </div>
                        <p class="task-description">Review and update all API documentation with latest changes and
                            examples.</p>
                        <div class="task-tags">
                            <span class="task-tag">Documentation</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar"></i>Feb 20
                                </span>
                                <span><i class="bi bi-chat"></i>2</span>
                            </div>
                            <div class="task-assignee" title="Mike Johnson">MJ</div>
                        </div>
                    </div>

                    <div class="task-card priority-high" draggable="true" data-task-id="3">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Database migration for new schema</h6>
                            <span class="priority-badge priority-high">High</span>
                        </div>
                        <p class="task-description">Create and test migration scripts for the new database schema
                            changes.</p>
                        <div class="task-tags">
                            <span class="task-tag">Database</span>
                            <span class="task-tag">Migration</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar"></i>Feb 12
                                </span>
                                <span><i class="bi bi-paperclip"></i>1</span>
                            </div>
                            <div class="task-assignee" title="John Doe">JD</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- To Do Column -->
            <div class="kanban-column" data-status="todo">
                <div class="column-header">
                    <div class="column-title">
                        <span class="column-icon icon-todo"></span>
                        To Do
                        <span class="column-count">2</span>
                    </div>
                    <button class="btn btn-sm" title="Column Options">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
                <div class="tasks-container" data-column="todo">
                    <div class="task-card priority-urgent" draggable="true" data-task-id="4">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Fix critical bug in payment gateway</h6>
                            <span class="priority-badge priority-urgent">Urgent</span>
                        </div>
                        <p class="task-description">Payment transactions are failing for certain card types. Needs
                            immediate attention.</p>
                        <div class="task-tags">
                            <span class="task-tag">Bug</span>
                            <span class="task-tag">Payment</span>
                            <span class="task-tag">Critical</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date overdue">
                                    <i class="bi bi-calendar-x"></i>Feb 08
                                </span>
                                <span><i class="bi bi-paperclip"></i>3</span>
                                <span><i class="bi bi-chat"></i>12</span>
                            </div>
                            <div class="task-assignee" title="Emma Wilson">EW</div>
                        </div>
                    </div>

                    <div class="task-card priority-high" draggable="true" data-task-id="5">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Design new dashboard layout</h6>
                            <span class="priority-badge priority-high">High</span>
                        </div>
                        <p class="task-description">Create mockups for the new analytics dashboard with improved UX.</p>
                        <div class="task-tags">
                            <span class="task-tag">Design</span>
                            <span class="task-tag">UI/UX</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar"></i>Feb 14
                                </span>
                                <span><i class="bi bi-paperclip"></i>5</span>
                                <span><i class="bi bi-chat"></i>3</span>
                            </div>
                            <div class="task-assignee" title="Alex Brown">AB</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- In Progress Column -->
            <div class="kanban-column" data-status="inprogress">
                <div class="column-header">
                    <div class="column-title">
                        <span class="column-icon icon-inprogress"></span>
                        In Progress
                        <span class="column-count">2</span>
                    </div>
                    <button class="btn btn-sm" title="Column Options">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
                <div class="tasks-container" data-column="inprogress">
                    <div class="task-card priority-high" draggable="true" data-task-id="6">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Build reporting module</h6>
                            <span class="priority-badge priority-high">High</span>
                        </div>
                        <p class="task-description">Implement custom report builder with export capabilities (PDF,
                            Excel, CSV).</p>
                        <div class="task-tags">
                            <span class="task-tag">Feature</span>
                            <span class="task-tag">Backend</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar"></i>Feb 18
                                </span>
                                <span><i class="bi bi-paperclip"></i>4</span>
                                <span><i class="bi bi-chat"></i>8</span>
                            </div>
                            <div class="task-assignee" title="John Doe">JD</div>
                        </div>
                    </div>

                    <div class="task-card priority-medium" draggable="true" data-task-id="7">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Optimize database queries</h6>
                            <span class="priority-badge priority-medium">Medium</span>
                        </div>
                        <p class="task-description">Profile and optimize slow queries. Add proper indexing and caching.
                        </p>
                        <div class="task-tags">
                            <span class="task-tag">Performance</span>
                            <span class="task-tag">Database</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar"></i>Feb 16
                                </span>
                                <span><i class="bi bi-chat"></i>4</span>
                            </div>
                            <div class="task-assignee" title="Sarah Miller">SM</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Review Column -->
            <div class="kanban-column" data-status="review">
                <div class="column-header">
                    <div class="column-title">
                        <span class="column-icon icon-review"></span>
                        Review
                        <span class="column-count">1</span>
                    </div>
                    <button class="btn btn-sm" title="Column Options">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
                <div class="tasks-container" data-column="review">
                    <div class="task-card priority-medium" draggable="true" data-task-id="8">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Code review: Feature X implementation</h6>
                            <span class="priority-badge priority-medium">Medium</span>
                        </div>
                        <p class="task-description">Review pull request for new feature implementation. Check code
                            quality and tests.</p>
                        <div class="task-tags">
                            <span class="task-tag">Code Review</span>
                            <span class="task-tag">Quality</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar"></i>Feb 10
                                </span>
                                <span><i class="bi bi-paperclip"></i>2</span>
                                <span><i class="bi bi-chat"></i>6</span>
                            </div>
                            <div class="task-assignee" title="Mike Johnson">MJ</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Done Column -->
            <div class="kanban-column" data-status="done">
                <div class="column-header">
                    <div class="column-title">
                        <span class="column-icon icon-done"></span>
                        Done
                        <span class="column-count">2</span>
                    </div>
                    <button class="btn btn-sm" title="Column Options">
                        <i class="bi bi-three-dots-vertical"></i>
                    </button>
                </div>
                <div class="tasks-container" data-column="done">
                    <div class="task-card priority-low" draggable="true" data-task-id="9">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">Setup CI/CD pipeline</h6>
                            <span class="priority-badge priority-low">Low</span>
                        </div>
                        <p class="task-description">Configure automated testing and deployment pipeline with GitHub
                            Actions.</p>
                        <div class="task-tags">
                            <span class="task-tag">DevOps</span>
                            <span class="task-tag">Automation</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar-check"></i>Feb 05
                                </span>
                                <span><i class="bi bi-chat"></i>3</span>
                            </div>
                            <div class="task-assignee" title="Emma Wilson">EW</div>
                        </div>
                    </div>

                    <div class="task-card priority-medium" draggable="true" data-task-id="10">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <h6 class="task-title">User feedback analysis</h6>
                            <span class="priority-badge priority-medium">Medium</span>
                        </div>
                        <p class="task-description">Analyze user feedback from last sprint and create action items.</p>
                        <div class="task-tags">
                            <span class="task-tag">Research</span>
                        </div>
                        <div class="task-footer">
                            <div class="task-meta">
                                <span class="due-date">
                                    <i class="bi bi-calendar-check"></i>Feb 06
                                </span>
                                <span><i class="bi bi-paperclip"></i>1</span>
                                <span><i class="bi bi-chat"></i>2</span>
                            </div>
                            <div class="task-assignee" title="Alex Brown">AB</div>
                        </div>
                    </div>
                </div>
            </div>
        </div> --}}

        <div class="board-container" id="kanbanBoard">

            @foreach($boards as $board)
                {{-- <h3 class="mb-4">{{ $board['name'] }}</h3>
                <p>{{ $board['description'] }}</p> --}}

                @foreach($board['columns'] as $column)
                    <div class="kanban-column" data-status="column-{{ $column['id'] }}">
                        <div class="column-header">
                            <div class="column-title">
                                <span class="column-icon"></span>
                                {{ $column['name'] }}
                                <span class="column-count">{{ count($column['tasks']) }}</span>
                            </div>
                            <button class="btn btn-sm" title="Column Options">
                                <i class="bi bi-three-dots-vertical"></i>
                            </button>
                        </div>

                        <div class="tasks-container" data-column="column-{{ $column['id'] }}">
                            @foreach($column['tasks'] as $task)
                                <div class="task-card priority-{{ strtolower($task['priority']) }}" draggable="true"
                                    data-task-id="{{ $task['id'] }}">
                                    <div class="d-flex justify-content-between align-items-start mb-2">
                                        <h6 class="task-title">{{ $task['title'] }}</h6>
                                        <span class="priority-badge priority-{{ strtolower($task['priority']) }}">
                                            {{ $task['priority'] }}
                                        </span>
                                    </div>
                                    <p class="task-description">{{ $task['description'] }}</p>

                                    @if(!empty($task['assignees']))
                                        <div class="task-assignees">
                                            @foreach($task['assignees'] as $assignee)
                                                <div class="task-assignee mt-1" title="{{ $assignee['name'] }}">
                                                    {{ strtoupper(substr($assignee['name'], 0, 2)) }}
                                                </div>
                                            @endforeach
                                        </div>
                                    @endif

                                    <div class="task-footer mt-1">
                                        <div class="task-meta">
                                            <span class="due-date">
                                                <i class="bi bi-calendar"></i>
                                                {{ \Carbon\Carbon::parse($task['due_date'])->format('Y/M/d') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach

                @break
            @endforeach
        </div>


    </div>



    <!-- New Task Modal -->
    @include('partials.create-task-modal')


    {{-- Scripts --}}
    @include('partials.scripts')
    @yield('scripts')
</body>

</html>