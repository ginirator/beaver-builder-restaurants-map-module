<?php
/**
 * This file should be used to render each module instance.
 */
?>
<script>
 //
</script>

<!--The div element for the map heading text -->
<?php
    $heading = $settings->heading ?? '';
    if ($heading) {
?>
    <div class="map-heading-text">
        <<?php echo $settings->tag; ?> class="fl-heading">
            <span class="fl-heading-text"><?php echo $heading; ?></span>
        </<?php echo $settings->tag; ?>>
    </div>
<?php } else { echo 'no heading found'; } ?>

<!--The div element for the map -->
<div id="map" style="width: 500px; height: 500px;"></div>

<!-- Async script executes immediately and must be after any DOM elements used in callback. -->
<script defer src="https://maps.googleapis.com/maps/api/js?key=<?php echo $settings->google_maps_api_key_field; ?>&libraries=places&callback=initMap&v=weekly"
    type="text/javascript"></script>
