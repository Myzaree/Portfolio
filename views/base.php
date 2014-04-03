<!DOCTYPE html>
<html>
<head>
    <?= $this->insert('Base/meta') ?>
    <?= $this->insert('Base/css') ?>
    <title>Cameron Condry - <?= $this->title ?> </title>
</head>
<body>
<div id="allwrap">
    <div id="sidebar">
        <?= $this->insert('Base/sidebar') ?>
    </div>

    <div id="main">
        <section>
            <?= $this->content ?>
            <hr/>
            <?php \App\Utility\Steve::results() ?>
        </section>
    </div>
</div>
</body>
</html>
