<!DOCTYPE html>
<html>
<head>
    <?= $this->insert('Base/meta') ?>
    <?= $this->insert('Base/css') ?>
    <title>Cameron Condry - <?= $this->title ?> </title>
</head>
<body>
<div id="allwrap">
    <div id="nav">
        <?= $this->insert('Base/nav') ?>
    </div>

    <div id="main-content">
        <div id="content">
            <section>
                <?= $this->section ?>
                <?= $this->stats ?>
            </section>
            <aside>
                <?= $this->aside ?>
            </aside>
        </div>
    </div>
</div>
</body>
</html>
