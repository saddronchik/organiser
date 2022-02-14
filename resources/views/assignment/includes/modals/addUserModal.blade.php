<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Добавление исполнителя</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <img src="{{ asset('img/icon/close.svg') }}" alt="close">
    </button>
</div>
<div class="modal-body">
    <form>
        <div class="form-group">
            <input type="text" class="form-control" id="fullname" name="fullname"
                   aria-describedby="fullnameHelp">
            <small id="fullnameHelp" class="form-text text-muted">Введите ФИО исполнителя</small>
        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger" data-dismiss="modal">Отменить</button>
    <button type="button" class="btn btn-primary">Сохранить</button>
</div>


