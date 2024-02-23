    // Function to allow drop
    function allowDrop(event) {
        event.preventDefault();
    }

    // Function to handle dropped files
    function handleDrop(event) {
        event.preventDefault();
        var files = event.dataTransfer.files;
        handleFiles(files);
    }

    // Function to handle selected files
    function handleFiles(files) {
        if (files.length === 1) {
            var file = files[0];
            var fileName = file.name;
            var fileSize = file.size;
            var fileExtension = fileName.split('.').pop().toLowerCase();
            if($.inArray(fileExtension, ["csv"]) == -1) {
                errorMsg('Please upload CSV file only.');
                return false;
            }

            if (file) {
                var email_row_check = false;
                var reader = new FileReader();

                reader.onload = function(e) {
                    var csvData = e.target.result;
                    var lines = csvData.split('\r\n');
                    var title_row = lines[0].split(',');
                    for (r = 0; r < title_row.length; r++)
                    {
                        var column_name = title_row[r].trim();
                        column_name = title_row[r].toLowerCase();
                        if(column_name == 'email'){
                            email_row_check = true;
                            var columnIndex = r;                            
                            break;
                        }
                    }
                    if(email_row_check){
                        var dataArray = processData(csvData, columnIndex);
                        if(dataArray.length !== 0){
                            storeRecodes(dataArray, fileSize);                            
                        }else{
                            errorMsg('No data found in the file.');
                            return false;
                        }
                    }else{
                        errorMsg('Email column not found. Please add Email as a column header.');
                        return false;
                    }
                    
                };

                reader.readAsText(file);
            }

        } else {
            errorMsg('Please drop only one file.');
            return false;
        }
       
    }

    // Clicking on the drop area triggers the file input click
    document.getElementById('dropArea').addEventListener('click', function() {
        document.getElementById('fileInput').click();
    });

    $(document).ready(function() {
        // Click event for the button
        $('#text-validate').on('click', function() {
            // Get data from the textarea
            var inputData = $('#input-textarea').val();

            // Split the data by commas
            var dataArray = inputData.replace(/\n/g, ',');

            if(dataArray.length !== 0){
                storeRecodes(dataArray);                            
            }else{
                errorMsg('No data.');
                return false;
            }

        });

        
        // initialized DataTable
        var listdatatable = $('#listTable').DataTable({
            processing: true,
            // serverSide: true,
            ajax: "/list_data",
            columns: [
                { data: 'id', name: 'id' },
                {
                    data: 'file_name',
                    name: 'filename',
                    render: function (data, type, row) {
                        
                        if(row.job_status == 'inprocess'){
                            var file_name_td = '<td>'
                            +'<span class="d-inline-block text-truncate">'
                            +'<a href="#">'                            
                            +'<span class="badge badge-pill bg-warning blink-icon">Inprocess</span>' 
                            +'<span> '+data+'</span>'
                            +'</a>'
                            +'</span>'
                            +'<br>'
                            +'<div class="row">'
                            +'<span class="sub-text-custom col-6 pt-2 pe-0">'
                            +'<i class="bi bi-calendar-event-fill"></i> '+row.create_time+'</span>'
                            +'<span class="sub-text-custom col-6 ps-0 pl-0 pt-2">'
                            +'<i class="bi bi-database-fill"></i> '+row.total_email+'</span>'
                            +'</div>'
                            +'</td>';
                        } else {
                            var file_name_td = '<td>'
                            +'<span class="d-inline-block text-truncate">'
                            +'<a href="#">'
                            +'<span title="completed" class="text-success campaign-status">'
                            +'<i class="bi bi-check-circle-fill"></i>'
                            +'</span>'
                            +'<span> '+data+'</span>'
                            +'</a>'
                            +'</span>'
                            +'<br>'
                            +'<div class="row">'
                            +'<span class="sub-text-custom col-6 pt-2 pe-0">'
                            +'<i class="bi bi-calendar-event-fill"></i> '+row.create_time+'</span>'
                            +'<span class="sub-text-custom col-6 ps-0 pl-0 pt-2">'
                            +'<i class="bi bi-database-fill"></i> '+row.total_email+'</span>'
                            +'</div>'
                            +'</td>';
                        }
                        return file_name_td;
                    }
                    
                },

                {
                    data: 'count_valid',
                    name: 'valid',
                    render: function (data, type, row) {
                        return '<td>'
                        +'<div class="font-weight-normal valid-color text-center">'
                        +'<span>'+data+'</span>'
                        +'<br>'
                        +'<span>'+row.count_valid_per+'</span>'
                        +'</div>'
                        +'</td>';
                    }
                    
                },
                {
                    data: 'count_invalid',
                    name: 'invalid',
                    render: function (data, type, row) {
                        return '<td>'
                        +'<div class="font-weight-normal invalid-color text-center">'
                        +'<span>'+data+'</span>'
                        +'<br>'
                        +'<span>'+row.count_invalid_per+'</span>'
                        +'</div>'
                        +'</td>';
                    }
                    
                },
                {
                    data: 'count_catchall',
                    name: 'catch all',
                    render: function (data, type, row) {
                        return '<td>'
                        +'<div class="font-weight-normal catch-color text-center">'
                        +'<span>'+data+'</span>'
                        +'<br>'
                        +'<span>'+row.count_catchall_per+'</span>'
                        +'</div>'
                        +'</td>';
                    }
                    
                },
                {
                    data: 'count_unknown',
                    name: 'unknown',
                    render: function (data, type, row) {
                        return '<td>'
                        +'<div class="font-weight-normal unknown-color text-center">'
                        +'<span>'+data+'</span>'
                        +'<br>'
                        +'<span>'+row.count_unknown_per+'</span>'
                        +'</div>'
                        +'</td>';
                    }
                    
                },

                {
                    name: 'action',
                    render: function (data, type, row) {
                        return '<td>'
                        +'<div class="text-center">'
                        +'<input type="hidden" class="job_status" value="'+row.job_status+'">'
                        +'<span class="campaign-status">'
                        +'<a href="/result/'+row.file_name+'" >'
                        +'<i class="bi bi-folder-symlink-fill fs-30"></i>'
                        +'</a>'
                        +'</span>'
                        +'</div>'
                        +'</td>';
                    }
                    
                },

                
            ]
        });

        setInterval( function () {
            $(".job_status").each(function(){
                if(this.value == 'inprocess'){
                    listdatatable.ajax.reload();
                    return false;
                }
            });
        }, 5000 );

    });

    

    function errorMsg(custText){
        $(".upload-error").text(custText);
        setTimeout(function() {
            $(".upload-error").text('');
        }, 5000); 
    }

    function processData(csvData, index) {
        var lines = csvData.split('\r\n');
        var data_array = '';
        for (i = 1; i < lines.length; ++i)
        {
            var email_column = lines[i].split(',');
            var email = email_column[index];
            if(email != ''){
                email = $.trim(email);
            }
            if(email != ''){
                data_array  += email+',';
            }
        }
        return data_array;
    }

    function updateCountdown() {
        var timerElement = $('#timer');
        var seconds = parseInt(timerElement.text());

        // Update countdown
        if (seconds > 0) {
            seconds--;
            timerElement.text(seconds);
            $('.countdown-timer').text(seconds);
        } else {
            $('#input-textarea').val('');
            // Reload page when countdown reaches 0
            location.reload();
        }
    }

    function storeRecodes(dataArray, fsize=null){
        var pageTime = 5;
        var userId = $('#user-id').val(); 
        var fname = $.now()+userId+ (fsize ? '_csv_file' : '_paste_emails');
        fname = fname.replace(/\s/g, "_");
        $('#dropArea').addClass('d-none');
        $('#pastArea').addClass('d-none');
        $('.file-pro-area').removeClass('d-none');
        $(".pro-file-name").html(fname);
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : '/emailVerifyRequest',
            data: {email:dataArray, filename:fname, filesize:fsize, uid:userId} ,
            type : 'POST',
            dataType : 'json',
            success : function(response){                        
                var obj = response;
                console.log(obj); 
                
                if(obj.status == 'success' && obj.save > 0){
                    console.log('save'); 
                    validateEmails(fname, userId);
                    var str = '<table class="table table-striped"><thead><tr><th scope="col" class="text-center">Total</th><th scope="col" class="text-center">Save</th><th scope="col" class="text-center">Duplicate</th></tr></thead><tbody><tr><td class="text-center theme-primary">'+obj.total+'</td><td class="text-center valid-color">'+obj.save+'</td><td class="text-center invalid-color">'+obj.duplicate+'</td></tr></tbody></table><div class="fs-11"><b>Note: </b>Duplicate emails has been removed from scan queue.</div><div id="countdown" class="fs-11">Page will reload in <span class="countdown-timer theme-primary fs-25">'+pageTime+'</span> seconds.<span id="timer" class="d-none">'+pageTime+'</span></div>';
                    setInterval(updateCountdown, 1000);
                } else {
                    var str = obj.message;
                }
                $('.result-status').html(str);
                $('.file-pro-area').addClass('d-none');                
            }
        });
    }


    function validateEmails(fname, userId){
        console.log('call'); 
        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url : '/validateEmailsRequest',
            data: {filename:fname, uid:userId} ,
            type : 'POST',
            dataType : 'json',
            success : function(response){
                console.log(response);
                if(response.status == 'success'){
                    // Reload page when job finished
                    location.reload();
                }                        
                console.log(response);
            }
        });
    }

    