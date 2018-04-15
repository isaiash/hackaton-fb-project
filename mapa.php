<!DOCTYPE html>
<html>
  <head>
  <?php
$username="root";
$password="";
$database="hack";

$connection=mysqli_connect ('localhost', $username, $password, $database);
if (!$connection) {
  die('Not connected : ' . mysqli_error());
}

$query = "SELECT * FROM markers WHERE 1";
$result = mysqli_query($connection,$query);
if (!$result) {
  die('Invalid query: ' . mysqli_error());
}

$ids = [];
$lats = [];
$lngs = [];
$tooltips = [];

while ($data = $result->fetch_assoc())
{

$html = '<div id="content_{$id}"> <b><font color="{$color}">[{$category}]</font></b><br/> <font >{$title}<br/> <a href="{$link}">Join Chatroom!</a></font> </div>';

$valores = array(
  '{$id}'=> $data["id"],
  '{$category}'=> $data["category"],
  '{$title}'=> $data["title"],
  '{$link}'=>$data["link"]);

if ($data["category"] == "EMERGENCY") {
  $valores['{$color}'] = "red";
} elseif ($data["category"] == "ENTERTAINMENT") {
  $valores['{$color}'] = "yellow";
} elseif ($data["category"] == "SPORTS") {
  $valores['{$color}'] = "green";
} elseif ($data["category"] == "EVENT") {
  $valores['{$color}'] = "blue";
}

  array_push($tooltips,strtr($html, $valores));
  array_push($ids, $data["id"]);
  array_push($lats, $data["lat"]);
  array_push($lngs, $data["lng"]);
}

?>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
    <title>Map</title>
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height: 100%;
      }
      /* Optional: Makes the sample page fill the window. */
      html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      }
      /* The location pointed to by the popup tip. */
      .popup-tip-anchor {
        height: 0;
        position: absolute;
        /* The max width of the info window. */
        width: 200px;
      }
      /* The bubble is anchored above the tip. */
      .popup-bubble-anchor {
        position: absolute;
        width: 100%;
        bottom: /* TIP_HEIGHT= */ 8px;
        left: 0;
      }
      /* Draw the tip. */
      .popup-bubble-anchor::after {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        /* Center the tip horizontally. */
        transform: translate(-50%, 0);
        /* The tip is a https://css-tricks.com/snippets/css/css-triangle/ */
        width: 0;
        height: 0;
        /* The tip is 8px high, and 12px wide. */
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: /* TIP_HEIGHT= */ 8px solid white;
      }
      /* The popup bubble itself. */
      .popup-bubble-content {
        position: absolute;
        top: 0;
        left: 0;
        transform: translate(-50%, -100%);
        /* Style the info window. */
        background-color: white;
        padding: 5px;
        border-radius: 5px;
        font-family: sans-serif;
        overflow-y: auto;
        max-height: 60px;
        box-shadow: 0px 2px 10px 1px rgba(0,0,0,0.5);
      }
    </style>
  </head>
  <body>
    <div id="map"></div>

    <?php
      foreach ($tooltips as $key => $value) {
        echo "$value";
      }
    ?>

    <script>
var map, popup, Popup;

/** Initializes the map and the custom popup. */
function initMap() {
  definePopupClass();

  map = new google.maps.Map(document.getElementById('map'), {
    zoom: 16,
  });

  var ids_array = <?php echo json_encode($ids); ?>;
  var lats_array = <?php echo json_encode($lats); ?>;
  var lngs_array = <?php echo json_encode($lngs); ?>;

  for (var i = 0; i < lats_array.length; i++) {
    popup = new Popup(
      new google.maps.LatLng(lats_array[i], lngs_array[i]),
      document.getElementById('content_'+ids_array[i])).setMap(map);
  }

  if (navigator.geolocation) {
         navigator.geolocation.getCurrentPosition(function (position) {
             initialLocation = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
             map.setCenter(initialLocation);
         });
     }
}

/** Defines the Popup class. */
function definePopupClass() {
  /**
   * A customized popup on the map.
   * @param {!google.maps.LatLng} position
   * @param {!Element} content
   * @constructor
   * @extends {google.maps.OverlayView}
   */
  Popup = function(position, content) {
    this.position = position;

    content.classList.add('popup-bubble-content');

    var pixelOffset = document.createElement('div');
    pixelOffset.classList.add('popup-bubble-anchor');
    pixelOffset.appendChild(content);

    this.anchor = document.createElement('div');
    this.anchor.classList.add('popup-tip-anchor');
    this.anchor.appendChild(pixelOffset);

    // Optionally stop clicks, etc., from bubbling up to the map.
    this.stopEventPropagation();
  };
  // NOTE: google.maps.OverlayView is only defined once the Maps API has
  // loaded. That is why Popup is defined inside initMap().
  Popup.prototype = Object.create(google.maps.OverlayView.prototype);

  /** Called when the popup is added to the map. */
  Popup.prototype.onAdd = function() {
    this.getPanes().floatPane.appendChild(this.anchor);
  };

  /** Called when the popup is removed from the map. */
  Popup.prototype.onRemove = function() {
    if (this.anchor.parentElement) {
      this.anchor.parentElement.removeChild(this.anchor);
    }
  };

  /** Called when the popup needs to draw itself. */
  Popup.prototype.draw = function() {
    var divPosition = this.getProjection().fromLatLngToDivPixel(this.position);
    // Hide the popup when it is far out of view.
    var display =
        Math.abs(divPosition.x) < 4000 && Math.abs(divPosition.y) < 4000 ?
        'block' :
        'none';

    if (display === 'block') {
      this.anchor.style.left = divPosition.x + 'px';
      this.anchor.style.top = divPosition.y + 'px';
    }
    if (this.anchor.style.display !== display) {
      this.anchor.style.display = display;
    }
  };

  /** Stops clicks/drags from bubbling up to the map. */
  Popup.prototype.stopEventPropagation = function() {
    var anchor = this.anchor;
    anchor.style.cursor = 'auto';

    ['click', 'dblclick', 'contextmenu', 'wheel', 'mousedown', 'touchstart',
     'pointerdown']
        .forEach(function(event) {
          anchor.addEventListener(event, function(e) {
            e.stopPropagation();
          });
        });
  };
}
    </script>
    <script async defer
    src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCpDr1hASekAMKNHAJIDbtyqcdXeBfDLAA&callback=initMap">
    </script>
  </body>
</html>