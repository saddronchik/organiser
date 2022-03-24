$(document).ready(function () {


    $('.dropdown-toggle').dropdown()

    let addAssignmentBtn = $('#add-assignment-btn');
    let searchBtn = $('.search-icon');
    let searchForm = document.querySelector('.form-search');
    const exportBtn = $('.exportBtn');
    let departmentSelect = $('.departmentSelect'),
        addressedSelect = $('.addressedSelect'),
        authorSelect = $('.authorSelect'),
        executorSelect = $('.executorSelect'),
        subExecutorsSelect = $('.subexecutors'),
        statusesSelect = $('.statusSelect');

    searchBtn.on('click', function (e) {
        searchForm.classList.toggle('b-show');
    })


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
        }
    });

    $.ajax({
        type: 'GET',
        url: '/organaizer/public/assignments/create',
        dataType: 'json',

        success: (data) => {
            let departmentsOption = '',
                usersOptions = '<option value=""></option>',
                statusesOption = '<option value=""></option>';


            if (data.status) {
                data.departments.forEach(function (item) {
                    departmentsOption += `<option value="${item.id}">${item.title}</option>`;
                })
                departmentSelect.html(departmentsOption)
                departmentSelect.selectpicker();

                data.users.forEach(function (item) {
                    usersOptions += `<option value="${item.id}">${item.full_name}</option>`;
                })

                authorSelect.html(usersOptions);
                authorSelect.selectpicker();
                addressedSelect.html(usersOptions);
                addressedSelect.selectpicker();
                executorSelect.html(usersOptions);
                executorSelect.selectpicker();
                subExecutorsSelect.html(usersOptions);
                executorSelect.selectpicker();
                subExecutorsSelect.selectpicker();


                data.statuses.forEach(function (item) {
                    statusesOption += `<option
                                    value="${item}">${item}</option>`;
                })
                statusesSelect.html(statusesOption);
                statusesSelect.selectpicker();
            }
        },
        error: (err) => {
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

    let addDepartmentBtn = $('.addDepartmentInput'),
        removeDepartmentBtn = $('.remove-department-input'),
        addAuthorBtn = $('.addAuthorInput'),
        removeAuthorBtn = $('.remove-author-input'),
        addAddressedBtn = $('.addAddressedInput'),
        removeAddressedBtn = $('.remove-addressed-input'),
        addExecutorBtn = $('.addExecutorInput'),
        removeExecutorBtn = $('.remove-executor-input');

    addDepartmentBtn.on('click', function (event) {
        $('.newDepartment').slideDown();
        $(this).slideUp();
        $('.departmentSelect').slideUp();
    })

    removeDepartmentBtn.on('click', function () {
        $('.newDepartment').slideUp();
        $('.departmentSelect').show();
        addDepartmentBtn.show();
    })

    addAuthorBtn.on('click', function () {
        $(this).hide();
        $('#author-select').toggleClass('d-none');
        $('.remove-author-input').show();
        $('.newAuthor').toggleClass('d-flex');
    })

    removeAuthorBtn.on('click', function (){
        $(this).hide();
        $('.author-select').toggleClass('d-none');
        $('.newAuthor').toggleClass('d-flex');
        addAuthorBtn.show();
    })

    addAddressedBtn.on('click', function () {
        $(this).hide();
        $('#addressed-select').toggleClass('d-none');
        $('.remove-addressed-input').show();
        $('.newAddressed').toggleClass('d-flex');
    })

    removeAddressedBtn.on('click', function (){
        $(this).hide();
        $('#addressed-select').toggleClass('d-none');
        $('.newAddressed').toggleClass('d-flex');
        addAddressedBtn.show();
    })

    addExecutorBtn.on('click', function (event) {
        $('.newExecutor').slideDown();
        $(this).hide();
        $('.executorSelect').slideUp();
    })

    removeExecutorBtn.on('click', function () {
        $('.newExecutor').slideUp();
        $('.executorSelect').slideDown();
        addExecutorBtn.show();
    })





    let editAssignmentBtn = $('.editAssignmentBtn');

    editAssignmentBtn.on('click', function () {
        let assignmentId = $(this).data('id');
        let editAssignmentModal = $('#edit-assignment'),
            departmentsOption = '';

        const spinner = $('.spinner-wrapper');

        spinner.removeClass('b-hide');
        editAssignmentModal.css('opacity', '0');

        editAssignmentModal.attr('action', `update/${assignmentId}`)

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type: 'get',
            url: '/organaizer/public/assignments/edit/' + assignmentId,
            dataType: 'json',

            success: (data) => {
                if (data.status) {
                    console.log(data.assignment)

                    let preamble = editAssignmentModal.find('#preambule'),
                        resolution = editAssignmentModal.find('#resolution'),
                        document_number = editAssignmentModal.find('#document_number'),
                        registerData = editAssignmentModal.find('#register-date'),
                        deadlineData = editAssignmentModal.find('#deadline'),
                        factDeadlineData = editAssignmentModal.find('#fact-deadline');

                    editAssignmentModal.find(`#department-select option[value=${data.assignment.department_id}]`)
                        .attr('selected', 'selected');
                    editAssignmentModal.find('#department-select').attr('title', data.assignment.department.title);
                    departmentSelect.selectpicker();

                    editAssignmentModal.find(`#author-select option[value=${data.assignment.author_id}]`)
                        .attr('selected', 'selected');

                    editAssignmentModal.find(`#addressed-select option[value=${data.assignment.addressed_id}]`)
                        .attr('selected', 'selected');

                    editAssignmentModal.find(`#executor-select option[value=${data.assignment.executor_id}]`)
                        .attr('selected', 'selected');

                    data.subexecutors.forEach((item) => {
                        editAssignmentModal.find(`#subexecutors-select option[value=${item.id}]`)
                            .attr('selected', 'selected');
                    });


                    editAssignmentModal.find(`#status-select option[value='${data.assignment.status}']`)
                        .attr('selected', 'selected');


                    preamble.val(data.assignment.preamble);
                    resolution.html(data.assignment.text);
                    document_number.val(data.assignment.document_number);

                    if (data.assignment.register_date) {
                        registerData.val(data.assignment.register_date.split(".").reverse().join("-"));
                    }

                    if (data.assignment.deadline) {
                        deadlineData.val(data.assignment.deadline.split(".").reverse().join("-"));
                    }

                    if (data.assignment.real_deadline) {
                        factDeadlineData.val(data.assignment.real_deadline.split(".").reverse().join("-"));
                    }


                    resolution.summernote();

                    spinner.addClass('b-hide');
                    editAssignmentModal.css('opacity', '1');

                }
            },

            error: (err) => {
                console.log(err);
            }
        })
    })

    const removeAssignmentBtn = $('.removeAssignmentBtn');

    removeAssignmentBtn.on('click', function () {
        let assignmentId = $(this).data('id');

        let isRemove = confirm('Удалить запись?');

        if (isRemove) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/organaizer/public/assignments/delete/' + assignmentId,
                method: 'DELETE',
                dataType: 'json',

                success: (data) => {
                    if (data.status) {
                        location.reload();
                    }
                },

                error: (err) => {
                    alert('Ошибка удаления поручения ' + assignmentId);
                }
            })
        }
    })

})
