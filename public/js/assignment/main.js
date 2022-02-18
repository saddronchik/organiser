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
                usersOptions = '',
                statusesOption = '';


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

    let addDepartmentBtn = $('#add-department-input'),
        removeDepartmentBtn = $('.removeInput');

    addDepartmentBtn.on('click', function (event) {
        let departmentFg = $('.newDepartment');
        departmentFg.slideDown();
        $(this).slideUp();
    })

    removeDepartmentBtn.on('click', function () {
        let departmentFg = $('.newDepartment');
        departmentFg.slideUp();
        addDepartmentBtn.slideDown();
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
                    console.log(data)

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


                    editAssignmentModal.find(`#status-select option[value=${data.assignment.statuses.id}]`)
                        .attr('selected', 'selected');


                    preamble.val(data.assignment.preamble);
                    resolution.html(data.assignment.text);
                    document_number.val(data.assignment.document_number);

                    registerData.val(data.assignment.created_at.split(".").reverse().join("-"));
                    deadlineData.val(data.assignment.deadline.split(".").reverse().join("-"));
                    factDeadlineData.val(data.assignment.real_deadline.split(".").reverse().join("-"));

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


})
