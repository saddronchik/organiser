@extends('assignment.layouts.assignment-layout')

@section('content')
    <section class="content">
        <div class="container filters">
            <!-- Top filters -->
            <div class="content-top">

                <div class="content-top__filters top__filters-left">
                    <div class="top__filters-col ">
                        <h5 class="items-count">Записей: </h5>
                        <select name="items-count" id="items-count" class="items-count_select">
                            <option value="15">15</option>
                            <option value="15">25</option>
                            <option value="15">50</option>
                        </select>
                    </div>

                    <div class="top__filters-col top__filters-middle">
                        <form action="#" class="form-search">
                            <input type="search" class="search-input" name="search" placeholder="Введите запрос...">
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
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="#">Выполнено</a>
                                    <a class="dropdown-item" href="#">Просрочено</a>
                                    <a class="dropdown-item" href="#">Без статуса</a>
                                    <div class="dropdown-divider"></div>
                                </div>
                            </div>

                            <img src="{{ asset('img/icon/download.svg') }}" class="export-icon" alt="export to xls"
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
                                @switch($assignment->statuses->status)
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
                                <td>{{ $assignment->department->title }}</td>
                                <td>{{ $assignment->document_number }}</td>
                                <td>{{ $assignment->created_at }}</td>
                                <td>{{ $assignment->addressed->full_name }}</td>
                                <td>{{ $assignment->executor->full_name }}</td>
                                <td>
                                    @foreach($assignment->users as $subexecutor)
                                        {{  $subexecutor->full_name }}
                                    @endforeach
                                </td>
                                <td>{{ $assignment->deadline }}</td>
                                <td>{{ $assignment->real_deadline }}</td>
                                <td>{{ $assignment->statuses->status }}</td
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
                                                    <a href="#" class="btn-edit" data-toggle="modal"
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
                                            <p class="card-body__text">
                                                <span>Текст резолюции:</span> <br>
{{--                                                {{ $assignment->text }}--}}
                                            </p>
                                        </div>
                                        <div class="card-footer">
                                            <p>
                                                <span>Автор резолюции: </span>
                                                {{ $assignment->author->full_name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach

{{--                        <tr class="table-row raw-column dead" data-toggle="collapse" data-target="#demo2"--}}
{{--                            class="accordion-toggle">--}}

{{--                            <td>1</td>--}}
{{--                            <td>Подразделение номер 1</td>--}}
{{--                            <td>1421110605668108</td>--}}
{{--                            <td>08.08.2022</td>--}}
{{--                            <td>Антонов Игорь Иванович</td>--}}
{{--                            <td>Иванов Иван Иванович</td>--}}
{{--                            <td>Чуркин П.М., Летов В.С., Мацок Л.М.</td>--}}
{{--                            <td>05.02.2022</td>--}}
{{--                            <td>11-04-2022</td>--}}
{{--                            <td>Просрочено</td>--}}
{{--                        </tr>--}}
{{--                        <tr>--}}
{{--                            <td colspan="10" class="hiddenRow">--}}
{{--                                <div class="accordian-body collapse column_content" id="demo2">--}}
{{--                                    <div class="card">--}}
{{--                                        <div class="card-header">--}}
{{--                                            Подробная информация 2--}}
{{--                                        </div>--}}
{{--                                        <div class="card-body">--}}
{{--                                            <p>--}}
{{--                                                <span>Преамбула: </span> <br>--}}
{{--                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Sunt, eum.--}}
{{--                                                <br>--}}
{{--                                            </p>--}}
{{--                                            <p class="card-body__text">--}}
{{--                                                <span>Текст резолюции:</span> <br>--}}
{{--                                                Lorem ipsum dolor sit amet consectetur adipisicing elit. Aliquid--}}
{{--                                                repellendus quaerat--}}
{{--                                                distinctio accusantium ipsam, <br> soluta voluptatem cupiditate--}}
{{--                                                illum quam quia, voluptatum--}}
{{--                                                reprehenderit voluptas atque sapiente, voluptate tempora aperiam--}}
{{--                                                dolorem? Nostrum?--}}
{{--                                            </p>--}}

{{--                                        </div>--}}
{{--                                        <div class="card-footer">--}}
{{--                                            <p>--}}
{{--                                                <span>Автор резолюции: </span>--}}
{{--                                                Ivanchenko K.M--}}
{{--                                            </p>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </td>--}}
{{--                        </tr>--}}

                        {{--                        <tr class="table-row raw-column dead">--}}
                        {{--                            <td>1</td>--}}
                        {{--                            <td>Подразделение номер 1</td>--}}
                        {{--                            <td>1421110605668108</td>--}}
                        {{--                            <td>08.08.2022</td>--}}
                        {{--                            <td>Антонов Игорь Иванович</td>--}}
                        {{--                            <td>Иванов Иван Иванович</td>--}}
                        {{--                            <td>Чуркин П.М., Летов В.С., Мацок Л.М.</td>--}}
                        {{--                            <td>05.02.2022</td>--}}
                        {{--                            <td>11-04-2022</td>--}}
                        {{--                            <td>Выполнено</td>--}}
                        {{--                        </tr>--}}

                        {{--                        <tr class="table-row raw-column success">--}}
                        {{--                            <td>1</td>--}}
                        {{--                            <td>Подразделение номер 1</td>--}}
                        {{--                            <td>1421110605668108</td>--}}
                        {{--                            <td>08.08.2022</td>--}}
                        {{--                            <td>Антонов Игорь Иванович</td>--}}
                        {{--                            <td>Иванов Иван Иванович</td>--}}
                        {{--                            <td>Чуркин П.М., Летов В.С., Мацок Л.М.</td>--}}
                        {{--                            <td>05.02.2022</td>--}}
                        {{--                            <td>11-04-2022</td>--}}
                        {{--                            <td>Выполнено</td>--}}
                        {{--                        </tr>--}}

                        {{--                        <tr class="table-row raw-column success">--}}
                        {{--                            <td>1</td>--}}
                        {{--                            <td>Подразделение номер 1</td>--}}
                        {{--                            <td>1421110605668108</td>--}}
                        {{--                            <td>08.08.2022</td>--}}
                        {{--                            <td>Антонов Игорь Иванович</td>--}}
                        {{--                            <td>Иванов Иван Иванович</td>--}}
                        {{--                            <td>Чуркин П.М., Летов В.С., Мацок Л.М.</td>--}}
                        {{--                            <td>05.02.2022</td>--}}
                        {{--                            <td>11-04-2022</td>--}}
                        {{--                            <td>Выполнено</td>--}}
                        {{--                        </tr>--}}

                        {{--                        <tr class="table-row raw-column success">--}}
                        {{--                            <td>1</td>--}}
                        {{--                            <td>Подразделение номер 1</td>--}}
                        {{--                            <td>1421110605668108</td>--}}
                        {{--                            <td>08.08.2022</td>--}}
                        {{--                            <td>Антонов Игорь Иванович</td>--}}
                        {{--                            <td>Иванов Иван Иванович</td>--}}
                        {{--                            <td>Чуркин П.М., Летов В.С., Мацок Л.М.</td>--}}
                        {{--                            <td>05.02.2022</td>--}}
                        {{--                            <td>11-04-2022</td>--}}
                        {{--                            <td>Выполнено</td>--}}
                        {{--                        </tr>--}}

                        {{--                        <tr class="table-row raw-column">--}}
                        {{--                            <td>1</td>--}}
                        {{--                            <td>Подразделение номер 1</td>--}}
                        {{--                            <td>1421110605668108</td>--}}
                        {{--                            <td>08.08.2022</td>--}}
                        {{--                            <td>Антонов Игорь Иванович</td>--}}
                        {{--                            <td>Иванов Иван Иванович</td>--}}
                        {{--                            <td>Чуркин П.М., Летов В.С., Мацок Л.М.</td>--}}
                        {{--                            <td>05.02.2022</td>--}}
                        {{--                            <td>11-04-2022</td>--}}
                        {{--                            <td></td>--}}
                        {{--                        </tr>--}}

                        {{--                        <tr class="table-row raw-column">--}}
                        {{--                            <td>1</td>--}}
                        {{--                            <td>Подразделение номер 1</td>--}}
                        {{--                            <td>1421110605668108</td>--}}
                        {{--                            <td>08.08.2022</td>--}}
                        {{--                            <td>Антонов Игорь Иванович</td>--}}
                        {{--                            <td>Иванов Иван Иванович</td>--}}
                        {{--                            <td>Чуркин П.М., Летов В.С., Мацок Л.М.</td>--}}
                        {{--                            <td>05.02.2022</td>--}}
                        {{--                            <td>11-04-2022</td>--}}
                        {{--                            <td></td>--}}
                        {{--                        </tr>--}}


                        </tbody>

                    </table>
                </div>
                {{ $assignments->onEachSide(3)->links() }}
            </div>
        </div>
    </section>

    {{-- Modals --}}

    <x-modal id="executorModal"/>
    <x-modal id="departmentModal"/>
    <x-modal id="add-assignment-modal" size="modal-lg"/>
    <x-modal id="edit-assignment-modal" size="modal-lg"></x-modal>

    {{--    End modals   --}}
@endsection

