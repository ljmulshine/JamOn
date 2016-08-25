<form action="play.php" method="post">
    <table id="table" class="table-hover" class="table-striped" border=1>
    <tr>
        <td class="tableHeader">Group Name</td>
        <td class="tableHeader">Click To Jam</td>
    <tr>
         <?php foreach ($groups as $group): ?>
            <tr>
                <td class="tableGroupName" ><?= $group['groupName'] ?></td>
                <td>     
                    <fieldset>
                        <button type="submit" name="group" value="<?= $group['groupName'] ?>" class="btn btn-default">Play Songs</button>
                    </fieldset>
                </td>
            </tr>
        <?php endforeach ?>
    </table>
</form>
<br>
<form action="update.php" method="post">
    <fieldset>
        <button id="updatePreferences" onClick="update()" type="submit" class="btn btn-default">Changed Favorites Recently?</button>
    </fieldset>
</form>


