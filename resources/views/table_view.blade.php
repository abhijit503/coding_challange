<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N"
        crossorigin="anonymous">
    <title>Table use api</title>

</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="pt-1">
                    <h3>first challenge</h3>
                </div>

                <div class="pt-5">
                    <input type="text" class="form-control float-right p-search-width mb-4" id="q" onkeyup="loadCompany()" placeholder="Search">
                    <input type="hidden" id="c_url">
                    <table class="table">
                        <thead class="thead-dark">
                            <tr>
                                <th scope="col">#uuid</th>
                                <th scope="col">name</th>
                            </tr>
                        </thead>
                        <tbody id="table">
                        </tbody>
                    </table>
                    <nav aria-label="Page navigation example" id="page">

                    </nav>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js" integrity="sha256-oP6HI9z1XaZNBrJURtCoUT5SUnxFr8s3BzRl+cbzUq8=" crossorigin="anonymous"></script>
    <script>
        $(window).on('load', () => {
        loadCompany(null);
    })

    function loadCompany(url_send) {
        var url = "";
        var q_data=$("#q").val();
        if(url_send==null){
            url = "http://localhost:8000/api/v1";
            if(q_data!=''){
                url+="?q="+q_data;
            }
        } else {
            url = url_send;
            if(q_data!=''){
                var url_sp=url_send.split('?q=');
                url=url_sp[0]+"?q="+q_data+url_sp[1];
            }
        }

        var companyData = "";
        var page_data="";

        $.ajax({
            method: "get",
            url: url,
            success: function(data) {
                data.items.forEach((item, key) => {
                    companyData += "<tr>" +
                        "<th>" + item.uuid + "</th>" +
                        "<td>" + item.name + "</td>" +
                        "</tr>";
                });
                page_data+='<ul class="pagination float-right">';

                for(var i=0;i<Number(data.metadata.total_page);i++){
                    var url_make='http://localhost:8000/api/v1'+'?q='+'&page='+(i+1);
                    var cur_u=data.metadata.current_url.split('&page=');
                    var active='';
                    if(Number(cur_u[1])==(i+1)){
                        active=' active';
                    }

                    page_data+='<li class="page-item'+active+'"><a class="page-link" onclick="loadCompany(\''+url_make+'\')">'+(i+1)+'</a></li>';
                }
                page_data+='<li class="page-item"><a class="page-link" onclick="loadCompany(\''+data.metadata.next_url+'\')">Next</a></li></ul>';


                if (companyData != "") {
                    $("#table").html(companyData);
                }else{
                    $("#table").html("<tr><td colspan='2'>no data found</td></tr>");
                }

                $("#page").html(page_data);
                if(q_data!=''){
                    $("#page").hide();
                }else{
                    $("#page").show();
                }

                $("#c_url").val(url);


            }
        });

    }
    </script>
</body>

</html>

<style>
    .p-search-width {
        width: 30%
    }
</style>
