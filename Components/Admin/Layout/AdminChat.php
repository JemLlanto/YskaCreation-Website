<?php
$sql = "SELECT * FROM chatroom WHERE chat_name='" . $_SESSION['chat_name'] . "'";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    ?>

    <div class="chat">
        <a href="../../chat_system/admin/chatroom.php?id=<?php echo $row['chatroomid']; ?>">
            <button value=" <?php echo $row['chatroomid']; ?>" type="button" class="btn  border-0" data-bs-toggle="tooltip"
                data-bs-placement="top" title="Tooltip on top">
                <img src="../../img/chat_icon.png" />
            </button>
        </a>
    </div>

<?php } ?>