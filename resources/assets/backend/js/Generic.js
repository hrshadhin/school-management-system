export default class Generic {
    /**
     * academic related codes
     */
    static initCommonPageJS() {
        $("#entryForm").validate({
            errorElement: "em",
            errorPlacement: function (error, element) {
                // Add the `help-block` class to the error element
                error.addClass("help-block");
                error.insertAfter(element);

            },
            highlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-error").removeClass("has-success");
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parents(".form-group").addClass("has-success").removeClass("has-error");
            }
        });

        $(".date_picker").datetimepicker({
            format: "dd/mm/yyyy",
            startView: 'month',
            minView: 'month',
            maxView: 'decade',
            autoclose: true,
            todayBtn: true
        });
        $(".date_picker2").datetimepicker({
            format: "dd/mm/yyyy",
            startView: 'decade',
            minView: 'month',
            maxView: 'decade',
            autoclose: true,
            todayBtn: true
        });

        var buttonCommon = {
            exportOptions: {
                columns: ':not(.notexport)',
                format: {
                    body: function (data, row, column, node) {
                        if(typeof(window.changeExportColumnIndex) !== 'undefined') {
                            if (column === window.changeExportColumnIndex) {
                                data = /checked/.test(data) ? 'Active' : 'Inactive';
                            }
                        }
                        return data;
                    }
                }
            }
        };

       //table with out search
        var table = $('#listDataTable').DataTable({
            pageLength: 25,
            lengthChange: false,
            responsive: true,
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copy',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'copy',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'csv',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'pdf',
                    customize: function (doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content[1].alignment = "center";
                    }
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'print',
                })
            ]
        });
        table.buttons().container().appendTo($('.col-sm-6:eq(0)', table.table().container()));



        //style table with search
        // Setup - add a text input to each footer cell
        $('#listDataTableWithSearch thead tr').clone(true).appendTo( '#listDataTableWithSearch thead' );
        $('#listDataTableWithSearch thead tr:eq(1) th').each( function (i) {

            if(window.excludeFilterComlumns.indexOf(i) > -1) {
                $(this).html( '' );
                return;
            }

            $(this).html( '<input type="text" placeholder="Search" />' );
            $( 'input', this ).on( 'keyup change', function () {
                if ( table2.column(i).search() !== this.value ) {
                    table2
                        .column(i)
                        .search( this.value )
                        .draw();
                }
            } );
        } );
        var table2 = $('#listDataTableWithSearch').DataTable({
            pageLength: 25,
            lengthChange: false,
            orderCellsTop: true,
            responsive: true,
            buttons: [
                $.extend(true, {}, buttonCommon, {
                    extend: 'copy',
                    text: '<i class="fa fa-files-o"></i>',
                    titleAttr: 'copy',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'csv',
                    text: '<i class="fa fa-file-text-o"></i>',
                    titleAttr: 'csv',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'excel',
                    text: '<i class="fa fa-file-excel-o"></i>',
                    titleAttr: 'Excel',
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'pdf',
                    text: '<i class="fa fa-file-pdf-o"></i>',
                    titleAttr: 'pdf',
                    customize: function (doc) {
                        doc.content[1].table.widths = Array(doc.content[1].table.body[0].length + 1).join('*').split('');
                        doc.content[1].alignment = "center";
                    }
                }),
                $.extend(true, {}, buttonCommon, {
                    extend: 'print',
                    text: '<i class="fa fa-print"></i>',
                    titleAttr: 'print',
                })
            ]
        });
        table2.buttons().container().appendTo($('.col-sm-6:eq(0)', table2.table().container()));




        let stopchange = false;
        $('html #listDataTableWithSearch, html #listDataTable').on('change', 'input.statusChange', function (e) {
            let that = $(this);
            if (stopchange === false) {
                let isActive = $(this).prop('checked') ? 1 : 0;
                let pk = $(this).attr('data-pk');
                let newpostUrl = postUrl.replace(/\.?0+$/, pk);
                axios.post(newpostUrl, { 'status': isActive })
                    .then((response) => {
                        if (response.data.success) {
                            toastr.success(response.data.message);
                        }
                        else {
                            let status = response.data.message;
                            if (stopchange === false) {
                                stopchange = true;
                                that.bootstrapToggle('toggle');
                                stopchange = false;
                            }
                            toastr.error(status);
                        }
                    }).catch((error) => {
                        let status = error.statusText;
                        if (stopchange === false) {
                            stopchange = true;
                            that.bootstrapToggle('toggle');
                            stopchange = false;
                        }
                        toastr.error(status);

                    });
            }
        });

        $(".year_picker").datetimepicker({
            format: "yyyy",
            autoclose: true,
            startView: 'decade',
            minView:'decade',
            maxView:'decade',
            viewSelect:'decade'
        });

        $('input').not('.dont-style').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' /* optional */
        });
        $('.select2').select2();


    }

    static initDeleteDialog() {
        $('html #listDataTableWithSearch, html #listDataTable').on('submit', 'form.myAction', function (e) {
            e.preventDefault();
            var that = this;
            swal({
                title: 'Are you sure?',
                text: 'You will not be able to recover this record!',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, keep it'
            }).then((result) => {
                if (result.value) {
                    that.submit();
                }
            });
        });
    }

    static loaderStart(){
        // console.log('loader started...');
        $('.ajax-loader').css('display','block');
    } 
    static loaderStop(){
        // console.log('loader stoped...');
        $('.ajax-loader').css('display','none');
    }
}