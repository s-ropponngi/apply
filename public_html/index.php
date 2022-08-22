<?php
require_once(__DIR__ .'/header.php');
$threadMod = new Apply\Model\Thread();
$threads = $threadMod->getThreadAll();
?>

<div class="home">
  <h1 class="ttl__area">Home</h1>
  <p class='letter'>少しでも迷子の子が少なくなりますように…<br>
     皆さんのお力をお貸しください。<br></p>
<div class="search__area">
  <form>
    <select class="title" name="title">
      <option value="">選択してください</option>
      <option value="保護しました" id = "c1">保護しました</option>
      <option value="探しています" id = "c2">探しています</option>
    </select>
    <select class="address" name="address" >
      <option value="" id="address">都道府県</option>
    </select>
  </form>
</div>

<ul id="thread" class="thread">
</ul><!-- thread -->

</div>


<?php
require_once(__DIR__ .'/footer.php');
?>
