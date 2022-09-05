<style>
    table,
    th,
    td {
        text-align: center;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.16.2/xlsx.full.min.js"></script>
<div class="modal fade" id="importModal" tabindex="-1" role="dialog" aria-labelledby="modal fade bd-prodcut-modal-lg" aria-hidden="true">
    <div class="modal-dialog " role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userLabel">Import Simulation Input</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="post" enctype="multipart/form-data" role="expunit-import">
                    @csrf
                    <div class="form-row">
                        <div class="form-group col-md-12">
                            <label class="control-label">Import Simulation Input
                                <span><i class="icon-sm" data-feather="info" data-toggle="tooltip" data-placement="top" title="Select .xlsx file"></i></span>
                            </label>
                            <div class="custom-file">
                                <input type="file" class="form-control" aria-label="Default" id="import_file" name="import_file">
                                <span class="text-danger" id="file-error" style="display:none">Please choose file</span>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="text-right">
                        <button type="button" id="modal_button_id" class="btn btn-sm btn-secondary submit" onclick="import_excel()">Upload
                        </button>
                        <!-- <button type="button" id="submit_spinner" data-request="ajax-submit" style="display: none;" data-target='[role="expunit-import"]' class="btn btn-sm btn-secondary submit" disabled>Upload
                            <span id="submit_spinner" class="spinner-border spinner-border-sm" role="status"></span>
                        </button> -->
                        <button class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </form>
                <!-- sample/generic_sample.xlsx -->
            </div>
        </div>
    </div>
</div>
<div id="wrapper" style="display:none"></div>
<script>
    $('#import_file').change(function(e) {
        var reader = new FileReader();
        reader.readAsArrayBuffer(e.target.files[0]);

        reader.onload = function(e) {
            var data = new Uint8Array(reader.result);
            var wb = XLSX.read(data, {
                type: 'array'
            });

            var htmlstr = XLSX.write(wb, {
                sheet: "Worksheet",
                type: 'binary',
                bookType: 'html'
            });
            $('#wrapper')[0].innerHTML += htmlstr;
            $("#file-error").hide();
        }
    });

    function import_excel(){
        //var CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
        var files = $('#import_file')[0].files;
        console.log(files[0])
        if(files.length > 0){
            var fd = new FormData();
            // Append data 
            fd.append('file',files[0]);
            fd.append('_token',$('meta[name="_token"]').attr('content'));
            // Hide alert 
            //$('#responseMsg').hide();
            // AJAX request 
            $.ajax({
            url: "{{url('experiment/experiment/configuration/uploadExcelSimInp')}}",
            method: 'post',
            data: fd,
            contentType: false,
            processData: false,
            dataType: 'json',
            success: function(response){
                console.log(response)
                if(response.success == 1){ // Uploaded successfully
                    //$("#file-error").show();
                    //$("#file-error").html(response.msg);
                    swal.fire({
                    text: "Template imported successfull.",
                    confirmButtonText: 'Close',
                    confirmButtonClass: 'btn btn-sm btn-danger',
                    width: '350px',
                    height: '10px',
                    icon: 'success',
                    toast: true,
                    position: "bottom-end",
                    showConfirmButton: false
                });
                    location.reload()
                }
                else
                {
                    $("#file-error").show();
                    $("#file-error").html(response.msg);
                }
            },
            error: function(response){
                console.log("error : " + JSON.stringify(response) );
            }
            });
        }else{
            alert("Please select a file.");
        }
     }

    /*function import_excel() {
        var filepath = document.getElementById('import_file').value
        if (filepath == "") {
            $("#file-error").show();
            $("#modal_button_id").show();
            $("#submit_spinner").hide();
            return;
        }
        var filename = filepath.split("\\").pop()
        var temp_details = (filename.substr(0, filename.lastIndexOf("."))).split('#');
        var template_id = temp_details[1];
        var type = temp_details[2];
        var table = document.getElementById('wrapper').getElementsByTagName("tr");
        var rowLength = table.length;
        var details = {};
        var cnt = 3
        $("#modal_button_id").hide();
        $("#submit_spinner").show();
        header1 = table[0].getElementsByTagName("td")
        header2 = table[1].getElementsByTagName("td")
        header3 = table[2].getElementsByTagName("td")
        for (i = 3; i < rowLength; i++) {
            rowcell = table[i].getElementsByTagName("td")
            for (j = 0; j < rowcell.length; j++) {
                details[j] = {};
                if (header3[j].innerText == '') {
                    details[j] = rowcell[j].innerText
                } else {
                    details[j][header3[j].innerText] = rowcell[j].innerText
                }
            }
            current_col = 0;
            details2 = []
            for (k = 0; k < header2.length; k++) {
                colspan = header2[k].getAttribute('colspan');
                if (colspan == null) {
                    colspan = 1
                }
                index = Number(colspan) + Number(current_col)
                //console.log(k+' '+current_col+' '+ colspan);
                details2[index] = []
                if (header2[k].innerText != '') {
                    details2[index] = {}
                    details2[index][header2[k].innerText] = []
                }
                for (h2 = current_col; h2 < Number(colspan) + Number(current_col); h2++) {

                    if (header2[k].innerText == '') {
                        details2[index] = details[h2]
                        //details2[index].push(details[h2])
                    } else {
                        details2[index][header2[k].innerText].push(details[h2])
                    }
                }
                current_col = Number(colspan) + Number(current_col)
            }
            current_col = 0;
            details1 = {}
            for (k = 0; k < header1.length; k++) {
                colspan = header1[k].getAttribute('colspan');
                if (colspan == null) {
                    colspan = 1
                }
                //console.log(k+' '+current_col+' '+ colspan+ ' '+header1[k].innerText);
                index = Number(colspan) + Number(current_col)
                details1[index] = []
                if (header1[k].innerText != '') {
                    details1[index] = {}
                    details1[index][header1[k].innerText] = []
                }
                for (h1 = current_col + 1; h1 <= Number(index); h1++) {
                    if (details2[h1] != undefined) {
                        if (header1[k].innerText == '') {
                            details1[index] = details2[h1];
                            //details1[index].push(details2[h1])
                        } else {
                            details1[index][header1[k].innerText].push(details2[h1])
                        }
                    }
                }
                current_col = Number(colspan) + Number(current_col)
            }
            console.log(details1);
            var objectexp = {
                "template_id": template_id,
                "details1": details1,
                "type": type,
            };
            event.preventDefault();
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                url: '{{ url("/experiment/experiment/configuration/insert_sim_input") }}',
                data: JSON.stringify(objectexp),
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    console.log(data.redirect);
                    cnt++
                    if (data.redirect === false) {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 6000
                        });
                        Toast.fire({
                            icon: 'error',
                            title: data.message,
                        })
                        $("#modal_button_id").show();
                        $("#submit_spinner").hide();
                        return;
                        //window.reload();

                    }
                    if (data.status === true) {
                        if (cnt == rowLength) {
                            const Toast = Swal.mixin({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            Toast.fire({
                                icon: 'success',
                                title: data.message,
                            })
                            location.href = data.redirect
                        }

                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.errors,
                        })
                    }
                },
            });
        }


    }*/
</script>