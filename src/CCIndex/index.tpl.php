<h1>Index Controller</h1>
<p>Welcome to Wolf index controller.</p>

<h2>Download</h2>
<p>You can download Wolf from github.</p>
<blockquote>
<code>git clone git://github.com/patricja/wolf.git</code>
</blockquote>
<p>You can review its source directly on github: <a href='https://github.com/patricja/wolf'>https://github.com/patricja/wolf</a></p>

<h2>Installation</h2>
<p>First you have to create the data-directory and make it writable. This is the place where Wolf needs
to be able to write and create files.</p>
<blockquote>
<code>cd wolf; mkdir site/data</code>
<br>
<code>chmod 777 site/data</code>
</blockquote>

<p>Then you have to change the .htaccess file</p>
<blockquote>
# Must use RewriteBase on www.student.bth.se, Rewritebase for url /~mos/test is /~mos/test/
</blockquote>

<p>Thrid, Wolf has some modules that need to be initialised. You can do this through a
controller. Point your browser to the following link.</p>
<blockquote>
<a href='<?=create_url('module/install')?>'>module/install</a>
</blockquote>
