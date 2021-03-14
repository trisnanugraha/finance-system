<script>
    $(function(){
        let startDate = "";
        let endDate = "";
        let akun = "";

        window.onload = function(){
            tampilAR(akun, startDate, endDate);
            tampilAkun();
        }

        $('#filter').on("click", function(){
            akun = $('#akun').find(':selected').val();
            startDate = $('#startDate').val();
            endDate = $('#endDate').val();
            tampilAR(akun, startDate, endDate);
        });

        function tampilAR(akun, startDate, endDate){
            $.ajax({
                url : "<?php echo base_url('AR/Tampil')?>",
                data : {akun : akun, startDate : startDate, endDate : endDate},
                type: "GET",
                datatype: "html",
                success: function(response){
                    MyTable.fnDestroy();
                    $("#data-ar").html(response);
                    refresh();
                }
            })
        }

        function tampilAkun() {
            $.getJSON('<?php echo base_url('Coa/getAkunARJson'); ?>',
                function(response) {
                    if (response.data.length > 0) {
                        response.data.forEach(function(item, index) {
                            $("#akun").append($('<option>', {
                                value: item.id_akun,
                                text: item.coa_id + ' ~ ' + item.coa_name 
                            }));
                        });
                    }
                });
        }    

        var id_ar;
        $(document).on("click", ".konfirmasiHapus-ar", function() {
            id_ar = $(this).attr("data-id");
        });

        var id_desc;

        $(document).on("click", ".hapus-dataAR", function() {
            var id = id_ar;

            $.ajax({
                    method: "POST",
                    url: "<?php echo base_url('AR/delete'); ?>",
                    data: "id_ar=" + id
                })
                .done(function(data) {
                    $('#konfirmasiHapus').modal('hide');
                    tampilAR();
                    $('.msg').html(data);
                    effect_msg();
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
                    url:"<?php echo base_url('AR/delete_all'); ?>",
                    method:"POST",
                    data: {checkbox_value : sendValue},
                })
                .done(function(data) {
                    tampilAR();
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