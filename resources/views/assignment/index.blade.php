@extends('assignment.layouts.assignment-layout')

@section('content')
    <section class="content">
        <div class="container filters">
            <!-- Top filters -->
            <div class="content-top">

                <div class="content-top__filters ">
                    <div class="top__filters-col top__filters-left">
                        <a href="{{ route('assignments.index') }}" title="Сбросить фильтры">
                            <img src="{{ asset('img/icon/reset.svg') }}" alt="Сбросить фильтры">
                        </a>
                    </div>

                    <div class="top__filters-col top__filters-middle">
                        <form action="?" method="get" class="form-search">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="id" class="col-form-label">№ документа</label>
                                        <input type="text" id="id" class="form-control" name="document_number"
                                               value="{{ request('document_number') }}">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="author" class="col-form-label">Автор</label>
                                        <select name="author" id="author" class="authorSelect"
                                                title="Автор"
                                                data-live-search="true"
                                                data-size="5">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="addressed" class="col-form-label">Кому адресовано</label>
                                        <select name="addressed" id="addressed-select" class="addressedSelect"
                                                title="Адресат"
                                                data-live-search="true"
                                                data-size="5">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="status" class="col-form-label">Подразделение</label>
                                        <select class="form-control departmentSelect" id="department-select"
                                                name="department"
                                                title="Выберите подразделение"
                                                data-size="5"
                                                data-live-search="true">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="role" class="col-form-label">Статус</label>
                                        <select class="form-select statusSelect" name="status" id="statuses"
                                                title="Выберите статус">
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-1">
                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="col-form-label">&nbsp;</label><br>
                                            <button type="submit" class="btn btn-primary">Найти</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    <div class="top__filters-col top__filters-right">
                        <div class="filters-actions">
                            <img src="{{ asset('img/icon/search.svg') }}" class="search-icon" alt="search" width="18px"
                                 title="Поиск">

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

                        @foreach($assignments as $assignment)
                            <tr class="table-row raw-column accordion-toggle
                                    @if ($assignment->isDone()) success @endif
                            @if ($assignment->isExpired()) dead @endif "
                                data-toggle="collapse" data-target="#{{ $assignment->id }}">
                                <td>{{ $assignment->id }}</td>
                                <td>{{ $assignment->department->title ?? ''}}</td>
                                <td>{{ $assignment->document_number ?? ''}}</td>
                                <td>{{ $assignment->register_date }}</td>
                                <td>{{ $assignment->addressed->full_name ?? ''}}</td>
                                <td>{{ $assignment->executor->full_name ?? ''}}</td>
                                <td>
                                    @foreach($assignment->users as $subexecutor)
                                        {{  $subexecutor->full_name }} <br>
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
                                                    <div class="card-header__actions d-flex">
                                                        @if (!$assignment->isDone())
                                                            <form action="{{ route('assignments.done', $assignment) }}"
                                                                  class="mr-1" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn-sm btn-success border-0">
                                                                    Пометить
                                                                    как <b>"Выполненно"</b></button>
                                                            </form>
                                                        @endif
                                                        @if (!$assignment->isExpired())
                                                            <form
                                                                action="{{ route('assignments.expire', $assignment) }}"
                                                                class="mr-1" method="post">
                                                                @csrf
                                                                <button type="submit" class="btn-sm btn-danger border-0">Пометить
                                                                    как
                                                                    <b>"Просрочено"</b></button>
                                                            </form>
                                                        @endif

                                                        <a href="#"
                                                           class="btn-sm btn-primary editAssignmentBtn mr-1"
                                                           data-toggle="modal" id="edit-assignment-btn"
                                                           data-id="{{ $assignment->id }}"
                                                           data-target="#edit-assignment-modal">
                                                            <img src="{{ asset('img/icon/edit.svg') }}"
                                                                 alt="edit-btn"
                                                                 width="15px">
                                                            Изменить</a>
                                                        <a href="#" class="btn-sm btn-warning removeAssignmentBtn"
                                                           id="remove-assignment-btn"
                                                           data-id="{{ $assignment->id }}"
                                                        >
                                                            <img src="{{ asset('img/icon/delete-icon-com.svg') }}"
                                                                 alt="удалить" width="15px">
                                                            Удалить
                                                        </a>
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

                        @endforeach
                        </tbody>
                    </table>
                </div>
                {{ $assignments->onEachSide(3)->links() }}
            </div>
            @if ($assignments->count() === 0)
                <div class="text-center">Ничего нет</div>
            @endif
        </div>
    </section>

    {{-- Modals --}}

    <x-modal id="executorModal"/>
    <x-modal id="departmentModal"/>
    <x-modal id="add-assignment-modal" size="modal-lg"/>
    <x-modal id="edit-assignment-modal" size="modal-lg"></x-modal>
    <x-modal id="export-assignment-modal"></x-modal>

    {{--    End modals   --}}
@endsection

