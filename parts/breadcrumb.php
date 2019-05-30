<?php if( is_page() && $post->post_parent ): ?>

<?php
$parent_id = $post->post_parent;
$parent_title = get_post($parent_id)->post_title; 
?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "item": {
        "@id": "<?php echo esc_url( home_url( '/' ) ); ?>",
        "name": "HOME"
      }
    }, {
      "@type": "ListItem",
      "position": 2,
      "item": {
        "@id": "<?php echo esc_url( get_permalink($parent_id) ); ?>",
        "name": "<?php echo $parent_title; ?>"
      }
    }, {
      "@type": "ListItem",
      "position": 3,
      "item": {
        "@id": "<?php the_permalink(); ?>",
        "name": "<?php the_title(); ?>"
      }
    }
  ]
}
</script>

<ol class="breadcrumb">
    <li class="breadcrumb__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a></li>
    <li class="breadcrumb__item"><a href="<?php echo esc_url( get_permalink($parent_id) ); ?>"><?php echo $parent_title; ?></a></li>
    <li class="breadcrumb__item"><?php the_title(); ?></li>
</ol>

<?php elseif( is_page() ): ?>

<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "item": {
        "@id": "<?php echo esc_url( home_url( '/' ) ); ?>",
        "name": "HOME"
      }
    }, {
      "@type": "ListItem",
      "position": 2,
      "item": {
        "@id": "<?php the_permalink(); ?>",
        "name": "<?php the_title(); ?>"
      }
    }
  ]
}
</script>

<ol class="breadcrumb">
    <li class="breadcrumb__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>">HOME</a></li>
    <li class="breadcrumb__item"><?php the_title(); ?></li>
</ol>

<?php elseif( is_single() ): ?>
<script type="application/ld+json">
{
  "@context": "http://schema.org",
  "@type": "BreadcrumbList",
  "itemListElement": [
    {
      "@type": "ListItem",
      "position": 1,
      "item": {
        "@id": "<?php echo esc_url( home_url( '/' ) ); ?>webhiko/",
        "name": "HOME"
      }
    }, {
      "@type": "ListItem",
      "position": 2,
      "item": {
        "@id": "<?php the_permalink(); ?>",
        "name": "<?php the_title(); ?>"
      }
    }
  ]
}
</script>

<div class="breadcrumbs">
    <ol class="breadcrumb">
        <li class="breadcrumb__item"><a href="<?php echo esc_url( home_url( '/' ) ); ?>webhiko/">HOME</a></li>
        <li class="breadcrumb__item"><?php the_title(); ?></li>
    </ol>
</div>

<?php endif; ?>