<?php
$pageTitle = 'Page Not Found (404) | Spa Design Hub';
$pageDescription = 'The page you are looking for has been moved or does not exist.';
$currentPage = '404';

require_once __DIR__ . '/includes/header.php';
?>

<main>
  <section class="page-header-luxury" style="min-height: 60vh; display: flex; align-items: center;">
    <div class="site-container text-center">
      <div class="eyebrow-pill" style="margin: 0 auto 1.5rem auto;">
        <span class="pill-dot" style="background-color: #EF4444;"></span>
        404 Error
      </div>
      <h1 style="font-size: clamp(2.5rem, 6vw, 4.5rem);">
        Page <span class="text-jade-accent">Not Found</span>.
      </h1>
      <p class="lead" style="max-width: 600px; margin: 1rem auto 2.5rem auto;">
        The page you are looking for may have been relocated, renamed, or is currently undergoing maintenance.
      </p>
      <div style="display: flex; justify-content: center; gap: 1.25rem; flex-wrap: wrap;">
        <a href="index.php" class="btn btn-primary">
          Return to Homepage
          <span class="btn-icon-wrapper">
            <svg viewBox="0 0 24 24"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
          </span>
        </a>
        <a href="book-a-call.php" class="btn btn-gold">
          Book a Discovery Call
        </a>
      </div>
    </div>
  </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
