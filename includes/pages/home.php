Home
<form id="form">



    string_variable
    <input name="string_variable"><br>
    string_variable_with_regex
    <input name="string_variable_with_regex"><br>

    <br>

    outer_string_variable
    <input name="outer_variable[outer_string_variable]"><br>
    outer_string_variable_with_regex
    <input name="outer_variable[outer_string_variable_with_regex]"><br>

    <br>

    <!-- inner_string_variable
    <input name="outer_variable[inner_variable[inner_string_variable]]"><br>
    inner_string_variable_with_regex
    <input name="outer_variable[inner_variable[inner_string_variable_with_regex]]"><br> -->






    <? $core->csrf("/api/endpoint") ?>
    <input type="submit">
</form>
<? $core->queueScript("init.js") ?>
