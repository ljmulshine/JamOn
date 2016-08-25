<table id="table" class="table-hover" class="table-striped" border=1>
<tr>
    <td class="tableHeader">Group Name</td>
    <td class="tableHeader">Group Members</td>
    <td class="tableHeader">Remove Specified User</td>    
</tr>        
 <?php foreach ($groups as $group): ?>
     <form action="updateGroupMembers.php" method="post">
        <tr>
            <td class="tableGroupName"><?= $group['groupName'] ?></td>
            <td>
                <select id="select" class="form-control" name="member">
                        <option>Members</option>
                    <?php foreach ($group['username'] as $username): ?>
                        <option value="<?= $username['username'] ?>" disabled> <?= $username['username'] ?> </option>
                    <?php endforeach ?>
                </select>
            </td>
            <td>     
                 <input id="users" name="user" type="text"/> <button name="group" value="<?= $group['groupName'] ?>" type="submit" class="btn btn-default">Remove User</button>
            </td>
        </tr>
    </form>    
<?php endforeach ?>
</table>


