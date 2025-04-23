<p>Hi,</p>
<p>{{ $userName }} commented on your post {{ $post->title }}</p>

<div style="color: green; font-size: 36px;">
    {{ $comment }}
</div>
<p>{{ $joke }}</p>


<a href="http://localhost:5500/post.html?id={{ $post->id }}">Click here to see the post</a>
