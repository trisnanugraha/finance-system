<script>
    $(function(){
        let startDate = "";
        let endDate = "";
        let customer = "";
        let owner = "";

        window.onload = function(){
            tampilBilling(customer, startDate, endDate);
            tampilCustomer(owner);
        }

        $('#filter').on("click", function(){
            customer = $('#customer').find(':selected').val();
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            tampilBilling(customer, startDate, endDate);
        });

        function tampilBilling(customer, startDate, endDate){
            $.ajax({
                url : "<?php echo base_url('Billing/Tampil')?>",
                data : {customer : customer, startDate : startDate, endDate : endDate},
                type: "GET",
                datatype: "html",
                success: function(response){
                    MyTable.fnDestroy();
                    $("#data-billing").html(response);
                    refresh();
                }
            })
        }

        function tampilCustomer(owner) {
            $.getJSON('<?php echo base_url('Customer/getCustomerJson'); ?>', {
                    owner: owner
                },
                function(response) {
                    if (response.data.length > 0) {
                        $("#customer").empty().append('<option selected value=""> --All customer-- </option>')
                        response.data.forEach(function(item, index) {
                            $("#customer").append($('<option>', {
                                value: item.kodeCus,
                                text: item.nama
                            }));
                        });
                    }
                });
        }

        var id_billing;
        $(document).on("click", ".konfirmasiHapus-billing", function() {
            id_billing = $(this).attr("data-id");
        });

        var id_desc;
        $(document).on("click", "#tambah-billing-period", function() {
            
            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Billing/multipleBillingPeriod'); ?>"
                })
                .done(function(data) {
                    $('#tempat-modal').html(data);
                    $('#add-billing-period').modal('show');
                });
        });

        $(document).on("click", ".hapus-dataBilling", function() {
            var id = id_billing;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('Billing/delete'); ?>",
                    data: "id=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilBilling();
                    $('.msg').html(data);
                    effect_msg();
                })
        });

        $(document).on("click", ".print-dataBilling", function() {
            var id = $(this).attr("data-id");
            var go_to_url = '<?php echo base_url('Billing/print/'); ?>' + id;
            window.open(go_to_url, '_blank');
        });

        $('#form-tambah-billing').submit(function(e) {
            var data = $(this).serialize();

            $.ajax({
                    method: 'POST',
                    url: '<?php echo base_url('Billing/prosesTambah'); ?>',
                    data: data
                })
                .done(function(data) {
                    var out = jQuery.parseJSON(data);

                    tampilBilling();

                    if (out.status == 'form') {
                        // $('.form-msg').html(out.msg);
                        // effect_msg_form();
                        $('#tambah-billing').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    } else {
                        document.getElementById("form-tambah-billing").reset();
                        $('#tambah-billing').modal('hide');
                        $('.msg').html(out.msg);
                        effect_msg();
                    }
                })

            e.preventDefault();
        });

        $('#tambah-billing').on('hidden.bs.modal', function() {
            $('.form-msg').html('');
        });

        $(document).on("click", ".konfirmasiHapus-billing", function() {
            id_billing = $(this).attr("data-id");
        });

        $(function() {
            $(".select2").select2();
        });

        $('#print-multiple-billing').on('shown.bs.modal', function(e) {

            $.get('<?= base_url('Billing/period'); ?>', function(data, status) {
                var markup;
                var dbSelect = $('.print-period');
                dbSelect.empty();
                dbSelect.append('<option selected disabled>Choose Period</option>');
                for (var i = 0; i < data.data.length; i++) {
                    dbSelect.append($('<option/>', {
                        value: data.data[i].id_periode,
                        text: moment(data.data[i].start_periode, 'YYYY/MM/DD').format('DD/MMM/YYYY') + ' ~ ' + moment(data.data[i].end_periode, 'YYYY/MM/DD').format('DD/MMM/YYYY')
                    }));
                }
            });
        });

        $(".kodeCus").on("change", function() {
            var id_customer = $(this).find(':selected').val();
            $.ajax({
                method: 'POST',
                url: '<?php echo base_url('Billing/tampilPeriodeCustomer'); ?>',
                data: {
                    kodeCus: id_customer
                },
                success: function(result) {
                    var markup;
                    var dbSelect = $('#period');
                    dbSelect.empty();
                    dbSelect.append('<option selected disabled>Choose Period</option>');
                    for (var i = 0; i < result.data.length; i++) {
                        dbSelect.append($('<option/>', {
                            value: result.data[i].id_periode,
                            text: moment(result.data[i].start_periode, 'YYYY/MM/DD').format('DD/MMM/YYYY') + ' ~ ' + moment(result.data[i].end_periode, 'YYYY/MM/DD').format('DD/MMM/YYYY')
                        }));
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(thrownError);
                }
            });
        });

       
        $("#check_all").click(function(){
            if($(this).is(":checked")){
                $(".check_item").prop("checked", true);
                $(this).closest('tr').addClass('removeRow');
            }else{
                $(".check_item").prop("checked", false);
                $(this).closest('tr').removeClass('removeRow');
            }
        });

        $('.check_item').click(function(){
            if($(this).is(':checked')){
                $(this).closest('tr').addClass('removeRow');
            }else{
                $(this).closest('tr').removeClass('removeRow');
            }
        });

        $(document).on("click", "#delete_all", function() {
            var checkbox = $('.check_item:checked');
            var confirm = window.confirm("Delete This Data ?")

            if(checkbox.length > 0 && confirm){
                var checkbox_value = new Array();
                
                $(checkbox).each(function(){
                    checkbox_value.push($(this).val());
                });

                sendValue = JSON.stringify(checkbox_value);

                console.log(sendValue);
                
                $.ajax({
                    url:"<?php echo base_url('Billing/delete_all'); ?>",
                    method:"POST",
                    data: {checkbox_value : sendValue},
                })
                .done(function(data) {
                    tampilBilling();
                    $('.msg').html(data);
                    effect_msg();
                    setInterval('location.reload()', 1000);
                })
                
            }else if(checkbox.length <= 0 && confirm){
               alert('Select at least one records');
            }else{}
        });
    });

</script>