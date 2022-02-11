<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Новое поручение</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="{{ asset('img/icon/close.svg') }}" alt="">
    </button>
</div>
<div class="modal-body">
    <form>
        <div class="form-group">

            <select class="form-control departmentSelect" id="department-select"
                    title="Выберите подразделение" data-header="Подразделение">
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="form-group">
            <small id="preambuleHelp" class="form-text text-muted">Преамбула</small>
            <textarea class="form-control" id="preambule" name="preambule" rows="3"></textarea>
        </div>
        <div class="form-group">
            <small id="resolutionHelp" class="form-text text-muted">Текст резолюции</small>
            <textarea class="form-control" id="resolution" name="resolution"
                      rows="5"></textarea>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="documentNumberHelp" class="form-text text-muted">Номер документа</small>
                <input type="number" class="form-control" name="docuemnt-number">
            </div>
            <div class="col">
                <small id="registerDateHelp" class="form-text text-muted">Дата регистрации</small>
                <input type="date" class="form-control" name="register-date">
            </div>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="authorHelp" class="form-text text-muted">Автор резолюции</small>
                <select class="form-control" id="author-select" name="author">
                    <option>Выберите автора...</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
            <div class="col">
                <small id="authorHelp" class="form-text text-muted">Кому адресована</small>
                <select class="form-control" id="author-select" name="author">
                    <option>Выберите автора...</option>
                    <option>2</option>
                    <option>3</option>
                    <option>4</option>
                    <option>5</option>
                </select>
            </div>
        </div>
        <div class="form-group">
            <small id="departmentHelp" class="form-text text-muted">Ответственный исполнитель</small>
            <select class="form-control executorSelect" id="executor-select"
                    title="Выберите исполнителя" data-header="Исполнитель" data-live-search="true">
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
            </select>
        </div>
        <div class="form-group">
            <small id="departmentHelp" class="form-text text-muted">Соисполнители</small>
            <select class="form-control subexecutors" id="subexecutors" title="Выберите соисполнителей"
                    data-size="3" data-header="Выберите соисполнителя" data-live-search="true" multiple>
                <option data-content="<span class='badge badge-primary'>Иванок И.К.</span>">Иванов И.К.
                </option>
                <option data-content="<span class='badge badge-primary'>Петров Е.М..</span>">Петров Е.М.
                </option>
                <option data-content="<span class='badge badge-primary'>Сидоров С.В.</span>">Сидоров
                    С.В.</option>
                <option data-content="<span class='badge badge-primary'>Черный Пистолет</span>">Черный
                    Пистолет</option>
            </select>
        </div>
        <div class="form-row">
            <div class="col">
                <small id="deadlineHelp" class="form-text text-muted">Срок исполнения</small>
                <input type="date" class="form-control" name="deadline">
            </div>
            <div class="col">
                <small id="factdeadlineHelp" class="form-text text-muted">Фактический срок
                    исполнения</small>
                <input type="date" class="form-control" name="fact-deadline">
            </div>
            <div class="col">
                <small id="statusHelp" class="form-text text-muted">Статус</small>
                <select class="form-control statusSelect" id="status-select" title="Статус">
                    <option data-content="<span style='background-color: #eee;''>Без статуса</span>">
                        Без статуса</option>
                    <option data-content="<span style='background-color: #2de0865b'>Выполненно</span>">
                        Выполненно</option>
                    <option
                        data-content="<span style='background-color: rgba(240, 138, 138, 0.200)'>Просрочено</span>">
                        Просрочено</option>
                </select>
            </div>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
    <button type="button" class="btn btn-primary">Сохранить</button>
</div>
