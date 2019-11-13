<div>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <textarea weird="fella">
    </textarea>
    <input name="fella" placeholder="click here">
    <input name="weird">
    <button id="test" onclick="thing()">test</button>
</table>
</div>

<script>
    /*
$(document).ready(function(){
    $("#test").click(function(){
        $("[weird='fella']").html("test");
    });
});

function thing(){
    $.myJquery();
}
$.myJquery = function(){
    $("[weird=fella]").html("test");
}*/

$(document).ready(function(){
    $("[name='fella']").click(function(){
        $("[name='weird']").val("test");
    });
});

</script>