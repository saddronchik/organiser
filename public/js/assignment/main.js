$(document).ready(function () {


$('.dropdown-toggle').dropdown()

let addAssignmentBtn = $('#add-assignment-btn');
let searchBtn = document.querySelector('.search-icon');
let searchForm = document.querySelector('.form-search');
let departmentSelect = $('.departmentSelect'),
    addressedSelect = $('.addressedSelect'),
    authorSelect = $('.authorSelect'),
    executorSelect = $('.executorSelect'),
    subExecutorsSelect = $('.subexecutors'),
    statusesSelect = $('.statusSelect');

searchBtn.addEventListener('click', function (e) {
    searchForm.classList.toggle('b-show');
})


$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
    }
});

$.ajax({
    type: 'GET',
    url: 'create',
    dataType: 'json',

    success: function (data) {
        let departmentsOption = '',
            usersOptions = '',
            statusesOption = '';


        if (data.status) {
            data.departments.forEach(function (item) {
                departmentsOption += `<option value="${item.id}">${item.title}</option>`;
            })
            departmentSelect.html(departmentsOption)
            departmentSelect.selectpicker();

            data.users.forEach(function (item) {
                usersOptions +=  `<option value="${item.id}">${item.full_name}</option>`;
            })
            authorSelect.html(usersOptions);
            addressedSelect.html(usersOptions);
            executorSelect.html(usersOptions);
            subExecutorsSelect.html(usersOptions);

            executorSelect.selectpicker();
            subExecutorsSelect.selectpicker();

            data.statuses.forEach(function (item) {
                statusesOption += `<option data-content='<span style="background-color: ${item.color};">${item.status}</span>'
                                    value="${item.id}">${item.status}</option>`;
            })
            statusesSelect.html(statusesOption);
            statusesSelect.selectpicker();
        }
        console.log(data)
    },
    error: function (err) {
        console.log(err)
    }
});





$('#resolution').summernote({
    toolbar: [
        ['style', ['bold', 'italic', 'underline', 'clear']],
        ['font', ['strikethrough', 'superscript', 'subscript']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        ['para', ['ul', 'ol', 'paragraph']],
        ['height', ['height']],
        ['view', ['fullscreen', 'codeview', 'help']],
    ]
});

})
