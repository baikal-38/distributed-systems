<?php
    include_once 'config/variables.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>Пользователи и права</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8;">
        <meta http-equiv="expires" content="0">
        <meta http-equiv="cashe-control" content="no-cashe">
</head>
<style>
	.tbl_1      {                                        border-color: #787878; border-width: .5pt .5pt .5pt .5pt; border-style: solid; border-collapse:collapse; }
	.td_1       { font-family: Verdana; font-size: 12px; border-color: #787878; border-width: .5pt .5pt .5pt .5pt; border-style: solid; }
        .td_2       { font-family: Verdana; font-size: 12px; border-color: #787878; border-width: .5pt .5pt .5pt .5pt; border-style: solid; font-weight: bold; text-align: center; cursor: pointer;}
        
        .p1         { font-family: Verdana; font-size: 14px;      }
</style>
<body>
<script>
    function addUser()
    {
        fetch('<?php    echo $url;    ?>',
            {
                method: "PUT",
                body: JSON.stringify(
                    {
                        object: 'user'
                    }
                ),
                headers: {
                    "Content-type": "application/json; charset=UTF-8"
                }
            }
        )
        .then((response) => response.json())
        .then((responseJson) => {
            this.getUsers(null);
        })
    }
    
    function deleteUser(obj_id)
    {
        if (window.confirm('Удалить пользователя?'))
        {
                fetch('<?php    echo $url;    ?>',
                    {
                        method: "DELETE",
                        body: JSON.stringify(
                            {
                                object: 'user',
                                id: obj_id
                            }
                        ),
                        headers: {
                            "Content-type": "application/json; charset=UTF-8"
                        }
                    }
                )
                .then((response) => response.json())
                .then((responseJson) => {
                    this.getUsers(null);
                })
        }
    }
    
    function saveUsers(obj_id)
    {
        var elements = document.getElementsByTagName("input");
        
        var payload = {
            object: 'user',
            id: obj_id
        };
        
        //str = "";
        
        for (var i = 0; i < elements.length; i++)
        {
            if (elements[i].type == "text"   && elements[i].name.indexOf("sl_input_users_col") == 0)
            {
                //str = str + '&' + elements[i].name + '=' + elements[i].value;
                if (elements[i].name == 'sl_input_users_col1') payload['name'] = elements[i].value;
                if (elements[i].name == 'sl_input_users_col2') payload['login'] = elements[i].value;
                if (elements[i].name == 'sl_input_users_col3') payload['pass'] = elements[i].value;
            }
        }
        //console.log(payload);
        
        
        fetch("<?php    echo $url;    ?>",
        {
            method: "POST",
            body: JSON.stringify( payload )
        })
        .then((response) => response.json())
        
    }
    
    getUsers(null);
    async function getUsers(edit_id)
    {        
        let response= await fetch('<?php    echo $url;    ?>?object=user')
        
        if (response.ok)
        {
            //console.log(response);
            let data= await response.json();
            //console.log(data);
            length = data.length;
            //console.log(length);
            var temp="<table class=tbl_1>";
            temp+="<tr>";
            temp+="<td class=td_2 style='width: 50px;'></td>";
            temp+="<td class=td_2 style='width: 50px;'></td>";
            temp+="<td class=td_2 style='width: 50px;'></td>";
            temp+="<td class=td_2 style='width: 50px;'>ID</td>";
            temp+="<td class=td_2 style='width: 150px;'>Name</td>";
            temp+="<td class=td_2 style='width: 150px;'>Login</td>";
            temp+="<td class=td_2 style='width: 150px;'>Password</td>";
            temp+="<td class=td_2 style='width: 150px;'>Created</td>";
            temp+="<td class=td_2 style='width: 150px;'>Modified</td>";
            temp+="</tr>";            
            for(i=0; i<length; i++)
            {
                str1 = "";
                str2 = "";
                str3 = "";
                str_end = "";
                if (Number.isInteger(edit_id) && edit_id == data[i].id)
                {
                    str1 = '<input name="sl_input_users_col1" style="width: 150px; background-color: #ff9999;" type=text value="';
                    str2 = '<input name="sl_input_users_col2" style="width: 150px; background-color: #ff9999;" type=text value="';
                    str3 = '<input name="sl_input_users_col3" style="width: 150px; background-color: #ff9999;" type=text value="';
                    str_end = '">';
                }
                    
                temp+="<tr>";
                temp+="<td class=td_2><img src='img/edit.jpg' onclick='getUsers(" + data[i].id + ");getRights(" + data[i].id + ",null)'></td>";
                temp+="<td class=td_2>";
                if (Number.isInteger(edit_id) && edit_id == data[i].id)
                {
                    temp+="<img src='img/save.jpg' onclick='saveUsers(" + data[i].id + ");'>";
                }
                temp+="</td>";
                temp+="<td class=td_2><img src='img/delete.jpg' onclick='deleteUser(" + data[i].id + ");'></td>";
                temp+="<td class=td_1>" +        data[i].id +               "</td>";
                temp+="<td class=td_1>" + str1 + data[i].name + str_end +   "</td>";
                temp+="<td class=td_1>" + str2 + data[i].login + str_end +  "</td>";
                temp+="<td class=td_1>" + str3 + data[i].pass + str_end +   "</td>";
                temp+="<td class=td_1>" +        data[i].created +          "</td>";
                temp+="<td class=td_1>" +        data[i].modified +         "</td>";
                temp+="</tr>";
            }
            temp +="</table>";

            document.getElementById("block_users").innerHTML=temp;
        }
        else 
        {
            alert("Ошибка HTTP: " + response.status);
        }
    }
    
    
    async function getRights(user_id, edit_id)
    {
        if (!Number.isInteger(user_id))
        {
            var temp="";
            temp+="<p class=p1 style='text-align: center;'>Права пользователя</p>";
            temp+="<p onclick='addRights();' class=p1 style='text-align: center; cursor: pointer; color: blue;'>Добавить права</p>";
            
            document.getElementById("block_rights").innerHTML=temp;
            return 0;
        }
        
        let response= await fetch('<?php    echo $url;    ?>?object=user_rights&user_id=' + user_id)
        
        if (response.ok)
        {
            //console.log(response);
            let data= await response.json();
            //console.log(data);
            length = data.length;
            //console.log(length);
            var temp="";
            
            temp+="<p class=p1 style='text-align: center;'>Права пользователя</p>";
            temp+="<p onclick='addRights();' class=p1 style='text-align: center; cursor: pointer; color: blue;'>Добавить права</p>";
            temp+="<table class=tbl_1>";
            temp+="<tr>";
            temp+="<td class=td_2 style='width: 50px;'></td>";
            temp+="<td class=td_2 style='width: 50px;'></td>";
            temp+="<td class=td_2 style='width: 50px;'></td>";
            temp+="<td class=td_2 style='width: 50px;'>ID</td>";
            temp+="<td class=td_2 style='width: 150px;'>Message</td>";
            temp+="<td class=td_2 style='width: 150px;'>Path</td>";
            temp+="<td class=td_2 style='width: 150px;'>User_id</td>";
            temp+="<td class=td_2 style='width: 150px;'>Created</td>";
            temp+="<td class=td_2 style='width: 150px;'>Modified</td>";
            temp+="</tr>";  
            
            for(i=0; i<length; i++)
            {
                str1 = "";
                str2 = "";
                str3 = "";
                str_end = "";
                if (Number.isInteger(edit_id) && edit_id == data[i].id)
                {
                    str1 = '<input name="sl_input_users_col1" style="width: 150px; background-color: #ff9999;" type=text value="';
                    str2 = '<input name="sl_input_users_col2" style="width: 150px; background-color: #ff9999;" type=text value="';
                    str3 = '<input name="sl_input_users_col3" style="width: 150px; background-color: #ff9999;" type=text value="';
                    str_end = '">';
                }
                    
                temp+="<tr>";
                temp+="<td class=td_2><img src='img/edit.jpg' onclick='getUsers(" + data[i].id + ");'></td>";
                temp+="<td class=td_2>";
                if (Number.isInteger(edit_id) && edit_id == data[i].id)
                {
                    temp+="<img src='img/save.jpg' onclick='saveUsers(" + data[i].id + ");'>";
                }
                temp+="</td>";
                temp+="<td class=td_2><img src='img/delete.jpg' onclick='deleteUser(" + data[i].id + ");'></td>";
                temp+="<td class=td_1>" +        data[i].id +                "</td>";
                temp+="<td class=td_1>" + str1 + data[i].message + str_end + "</td>";
                temp+="<td class=td_1>" + str2 + data[i].path + str_end +    "</td>";
                temp+="<td class=td_1>" + str3 + data[i].user_id + str_end + "</td>";
                temp+="<td class=td_1>" +        data[i].created +           "</td>";
                temp+="<td class=td_1>" +        data[i].modified +          "</td>";
                temp+="</tr>";
            }
            
            temp +="</table>";

            document.getElementById("block_rights").innerHTML=temp;
        }
        else 
        {
            //alert("Ошибка HTTP: " + response.status);
            var temp="";
            temp+="<p class=p1 style='text-align: center;'>Права пользователя</p>";
            temp+="<p onclick='addRights();' class=p1 style='text-align: center; cursor: pointer; color: blue;'>Добавить права</p>";
            
            document.getElementById("block_rights").innerHTML=temp;
        }
    }
    //showUsers("block_users");
</script>
    <p onclick='addUser();getRights(null,null);' class=p1 style="text-align: center; cursor: pointer; color: blue;">Добавить пользователя</p>
    <div id="block_users">
    </div>
    
    <div id="block_rights">
    </div>
</body>
</html>
