@extends('assignment.layouts.assignment-layout')

@section('content')
    <section class="content">
        <div class="container filters">
            <!-- Top filters -->
            <div class="content-top">

                <div class="content-top__filters top__filters-left">
                    <div class="top__filters-col ">
                        <a href="{{ route('assignments.index') }}" title="Сбросить фильтры">
                            <img src="{{ asset('img/icon/reset.svg') }}" alt="Сбросить фильтры">
                        </a>
                    </div>

                    <div class="top__filters-col top__filters-middle">
                        <form action="{{ route('search-assignment') }}" method="get" class="form-search">
                            @csrf
                            <input type="search" class="search-input" name="search" placeholder="Номер документа или автор, или адресат">
                            <button type="submit" class="btn btn-primary search-btn">Поиск</button>
                        </form>
                    </div>

                    <div class="top__filters-col top__filters-right">
                        <div class="filters-actions">
                            <img src="{{ asset('img/icon/search.svg') }}" class="search-icon" alt="search" width="18px"
                                 title="Поиск">

                            <div class="btn-group dropdown">
                                <button type="button" class="btn btn-outline dropdown-toggle filter-btn"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <img src="{{ asset('img/icon/status-sort (2).svg') }}" alt="time-icon" width="18"
                                         title="Сортировать по статусу">
                                </button>
                                <div class="dropdown-menu dropdown-menu-right" id="status-dropdown">
                                    <a href="{{ route('assignments.index') }}" class="dropdown-item">Все</a>
                                    @foreach($statuses as $status)
                                        <a class="dropdown-item" href="{{ route('sort-by-status', $status), }}">{{ $status }}</a>
                                    @endforeach
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>

                            <div class="departments-filter">
                                <div class="btn-group dropdown">
                                    <button type="button" class="btn btn-outline dropdown-toggle filter-btn"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <img src="{{ asset('img/icon/departments.svg') }}" alt="time-icon" width="18"
                                             title="Сортировать по подразделениям">
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" id="department-dropdown">
                                        <a href="{{ route('assignments.index') }}" class="dropdown-item">Все</a>
                                        @foreach($departments as $department)
                                            <a class="dropdown-item" href="{{ route('sort-by-department', $department->id) }}">{{ $department->title }}</a>
                                        @endforeach
                                        <div class="dropdown-divider"></div>
                                    </div>
                                </div>
                            </div>

                            <img src="{{ asset('img/icon/download.svg') }}" class="exportBtn"
                                 data-toggle="modal"
                                 data-target="#export-assignment-modal"
                                 alt="export to xls"
                                 width="18px"
                                 title="Создать отчет">
                        </div>
                    </div>
                </div>
            </div>
            <!-- end top filters -->

            <div class="content-main">

                <div class="table-wrapper">
                    <table class="table table-borderless table-hover caption-top" style="border-collapse:collapse;">

                        <thead class="text-center">
                        <tr class="">
                            <th class="table__header pb-3" rowspan="2">№ п/п</th>
                            <th class="table__header pb-3" rowspan="2">Подразделение</th>
                            <th class="table__header pb-3" rowspan="2">Номер документа</th>
                            <th class="table__header pb-3" rowspan="2">Регистрация</th>
                            <th class="table__header pb-3" rowspan="2">Адресовано</th>
                            <th class="table__header pb-3" rowspan="2">Исполнитель</th>
                            <th class="table__header pb-3" rowspan="2">Соисполнители</th>
                            <th class="table__header pb-3" rowspan="2">Срок исполнения</th>
                            <th class="table__header pb-3" rowspan="2">Фактический срок исполнения</th>
                            <th class="table__header pb-3" rowspan="2">Статус</th>
                        </tr>
                        </thead>

                        <tbody id="table-body">

                        @forelse($assignments as $assignment)

                            <tr class="table-row raw-column accordion-toggle
                                @switch($assignment->status)
                                    @case('Просрочено')
                                        dead
                                        @break
                                    @case('Выполнено')
                                        success
                                        @break
                                @endswitch
                                    "
                                data-toggle="collapse" data-target="#{{ $assignment->id }}">
                                <td>{{ $assignment->id }}</td>
                                <td>{{ $assignment->department->title ?? ''}}</td>
                                <td>{{ $assignment->document_number ?? ''}}</td>
                                <td>{{ $assignment->created_at }}</td>
                                <td>{{ $assignment->addressed->full_name ?? ''}}</td>
                                <td>{{ $assignment->executor->full_name ?? ''}}</td>
                                <td>
                                    @foreach($assignment->users as $subexecutor)
                                        {{  $subexecutor->full_name }}
                                    @endforeach
                                </td>
                                <td>{{ $assignment->deadline ?? '' }}</td>
                                <td>{{ $assignment->real_deadline ?? null }}</td>
                                <td>{{ $assignment->status }}</td>
                            </tr>

                        <tr>
                            <td colspan="10" class="hiddenRow">
                                <div class="accordian-body collapse column_content" id="{{ $assignment->id }}">
                                    <div class="card">
                                        <div class="card-header">
                                            <div class="card-header__wrapper">
                                                <div class="card-header__title">
                                                    <h5>Подробная информация</h5>
                                                </div>
                                                <div class="card-header__actions">
                                                    <a href="#" class="btn-edit editAssignmentBtn" data-toggle="modal" id="edit-assignment-btn"
                                                       data-id="{{ $assignment->id }}"
                                                       data-target="#edit-assignment-modal">
                                                        <img src="{{ asset('img/icon/edit.svg') }}" alt="edit-btn"
                                                             width="15px">
                                                        Изменить</a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <p>
                                                <span>Преамбула: </span> <br>
                                                    {{ $assignment->preamble }}
                                                <br>
                                            </p>
                                            <div class="card-body__text text-wrap">
                                                <span>Текст резолюции:</span> <br>
                                                <p>{!! $assignment->text !!} </p>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <p>
                                                <span>Автор резолюции: </span>
                                                {{ $assignment->author->full_name ?? ''}}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        @empty
                            <div class="text-center">
                                <h4>Ничего не найдено</h4>
                            </div>

                        @endforelse

                        </tbody>

                    </table>
                </div>
                {{ $assignments->onEachSide(3)->links() }}
            </div>
        </div>
    </section>

    {{-- Modals --}}

    <x-modal id="executorModal" />
    <x-modal id="departmentModal" />
    <x-modal id="add-assignment-modal" size="modal-lg" />
    <x-modal id="edit-assignment-modal" size="modal-lg" ></x-modal>
    <x-modal id="export-assignment-modal"></x-modal>

    {{--    End modals   --}}
@endsection

