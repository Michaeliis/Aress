<html>
    <form name="a" action="<?= base_url('Contest/insertIntent')?>" method="post">
        <table>
            <tr>
                <td>
                    Intent Name :
                </td>
                <td>
                    <input type="text" name="intentName" id="intentName">
                </td>
            </tr>
            <tr>
                <td>
                    Keyword 1 :
                </td>
                <td>
                    <input type="text" name="keyword1" id="keyword1">
                </td>
            </tr>

            <tr>
                <td>
                    Keyword 2 :
                </td>
                <td>
                    <input type="text" name="keyword2" id="keyword2">
                </td>
            </tr>

            <tr>
                <td>
                    Sample :
                </td>
                <td>
                    <input type="text" name="sample" id="sample">
                </td>
            </tr>
        </table>
        <input type="submit" name="submit">
    </form>
    
    <a href=<?= base_url("Contest/")?>>Home</a>
</html>