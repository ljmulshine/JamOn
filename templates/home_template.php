<form action="playSong.php" method="post">
<div>
    <h2 class="tableGroupName">Welcome, <?= $_SESSION["username"] ?></h3>
</div>
<br>
<h3>Song Favorites</h4>
<br>
<div>
    <table class="table-hover" border=1>
        <?php foreach ($playlist as $song): ?>
            <tr>
                <td class="tableImage"><img class="image2" src="<?= $song['user']['avatar_url'] ?>"></td>
                <td class="songName"> <?= $song["title"] ?></td>
                <td><button type="submit" name="song" value="<?= $song['permalink_url'] ?>" class="btn btn-default">Play Song</button></td>
            </tr>
        <?php endforeach ?>
    </table>
</div>
<br>
<a href="logout.php">Log Out</a>
</br>
</form>
