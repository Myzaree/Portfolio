<?php $this->layout('base') ?>
<?php $this->title = 'Home' ?>

<?php $this->start('section') ?>
<h2>Projects</h2>
<h3>Project 1:</h3>
<p><a href="#">Cameron Condry</a></p>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Deleniti ducimus illo non quas reiciendis? Accusamus cupiditate deleniti dolor doloribus exercitationem in laboriosam maxime natus neque nobis non quae, saepe sed similique sint vel veniam? Aut ea earum quia recusandae temporibus. Corporis culpa debitis, distinctio eos error illo porro repellendus tenetur!</p>
<h3>Project 2:</h3>
<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ad alias, aperiam architecto aspernatur at commodi cumque dolorum eos eveniet excepturi expedita explicabo hic ipsa labore laborum magni maiores molestias natus necessitatibus, nesciunt obcaecati omnis pariatur perspiciatis placeat quae quidem quis quos ratione repellendus sed, sequi tempora tempore velit vitae voluptatum?</p>
<?php $this->end() ?>

<?php $this->start('aside') ?>
<h1>Cameron Condry</h1>
<h3>Web Developer</h3>
<p>Describe Current Job: Lorem ipsum dolor sit amet, consectetur adipisicing elit. A animi atque dignissimos distinctio fugiat impedit incidunt iste iure laudantium maiores nesciunt odio praesentium quisquam quo quod, repellat, tenetur velit voluptatum. Aperiam cum dignissimos dolorum earum eos fugiat ipsa, itaque odit perferendis possimus praesentium saepe veritatis vitae! Cumque ea maxime non quae, quia quis temporibus tenetur voluptate. Consectetur cupiditate dignissimos excepturi inventore molestias nisi nobis officia provident, quas qui quibusdam quis repellat repellendus rerum totam veritatis.</p>
<?php $this->end() ?>

<?php $this->start('stats') ?>
<hr/>
<?php \App\Utility\Steve::results() ?>
<?php $this->end() ?>
