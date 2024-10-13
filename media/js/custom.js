if (!window.Joomla) {
  throw new Error("Joomla API was not properly initialised");
}

const { tokenmapbox } = Joomla.getOptions("mod_mapbox.vars");
const { stylemapbox } = Joomla.getOptions("mod_mapbox.vars");
// const { longitudemapbox } = Joomla.getOptions('mod_mapbox.vars');
// const { latitudemapbox } = Joomla.getOptions('mod_mapbox.vars');
const { listofpoints } = Joomla.getOptions("mod_mapbox.vars");
const { zoommapbox } = Joomla.getOptions("mod_mapbox.vars");
const { geotitle } = Joomla.getOptions("mod_mapbox.vars");
const { geodescription } = Joomla.getOptions("mod_mapbox.vars");
const { markermapbox } = Joomla.getOptions("mod_mapbox.vars");
document.addEventListener("DOMContentLoaded", function () {
  mapboxgl.accessToken = tokenmapbox;
  let originalData = listofpoints;
  // Iteracja po istniejących punktach
  // Tworzymy tablicę, która będzie zawierać nowe obiekty typu "Feature"
  let features = [];
  for (let key in originalData) {
    let point = originalData[key];

    // Tworzenie nowej struktury typu "Feature" dla każdego punktu
    let feature = {
      type: "Feature",
      geometry: {
        type: "Point",
        coordinates: [parseFloat(point.longitudemapbox), parseFloat(point.latitudemapbox)],
      },
      properties: {
        title: point.geotitle,
        description: point.geodescription,
      },
    };

    // Dodawanie nowego obiektu do tablicy features
    features.push(feature);
  }

  // Wyświetlenie wyniku
  const geojson = {
    type: "FeatureCollection",
    features: features,
  };
  //ustawienie m.innymi znacznika pierwszej koordynaty w centrum mapy
  const map = new mapboxgl.Map({
    container: "map",
    style: stylemapbox,
    zoom: zoommapbox,
    center: [features[0].geometry.coordinates[0], features[0].geometry.coordinates[1]],
  });

  // add markers to map
  for (const feature of geojson.features) {
    // create a HTML element for each feature
    const el = document.createElement("div");
    el.className = "marker";

    // make a marker for each feature and add to the map
    new mapboxgl.Marker(el).setLngLat(feature.geometry.coordinates).addTo(map);

    new mapboxgl.Marker(el)
      .setLngLat(feature.geometry.coordinates)
      .setPopup(
        new mapboxgl.Popup({ offset: 25 }) // add popups
          .setHTML(`<h3>${feature.properties.title}</h3><p>${feature.properties.description}</p>`)
      )
      .addTo(map);
  }

  map.addControl(new mapboxgl.NavigationControl());
  map.scrollZoom.disable();

  map.on("style.load", () => {
    map.setFog({}); // Set the default atmosphere style
  });

  // The following values can be changed to control rotation speed:

  // At low zooms, complete a revolution every two minutes.
  const secondsPerRevolution = 240;
  // Above zoom level 5, do not rotate.
  const maxSpinZoom = 5;
  // Rotate at intermediate speeds between zoom levels 3 and 5.
  const slowSpinZoom = 3;

  let userInteracting = false;
  const spinEnabled = true;

  function spinGlobe() {
    const zoom = map.getZoom();
    if (spinEnabled && !userInteracting && zoom < maxSpinZoom) {
      let distancePerSecond = 360 / secondsPerRevolution;
      if (zoom > slowSpinZoom) {
        // Slow spinning at higher zooms
        const zoomDif = (maxSpinZoom - zoom) / (maxSpinZoom - slowSpinZoom);
        distancePerSecond *= zoomDif;
      }
      const center = map.getCenter();
      center.lng -= distancePerSecond;
      // Smoothly animate the map over one second.
      // When this animation is complete, it calls a 'moveend' event.
      map.easeTo({ center, duration: 1000, easing: (n) => n });
    }
  }

  // Pause spinning on interaction
  map.on("mousedown", () => {
    userInteracting = true;
  });
  map.on("dragstart", () => {
    userInteracting = true;
  });

  // When animation is complete, start spinning if there is no ongoing interaction
  map.on("moveend", () => {
    spinGlobe();
  });
  spinGlobe();
  //zmiana markera na własny
  document.querySelectorAll(".marker").forEach((element) => {
    element.style.backgroundImage = "url(" + "/" + markermapbox.imagefile + ")";
    if (!markermapbox.alt_empty) element.setAttribute("alt", markermapbox.alt_text);
  });
  const tableMapbox = document.querySelector(".table-mapbox");
  tableMapbox.addEventListener("click", (e) => {
    const tableElement = e.target.parentNode;
    const longitude = tableElement.querySelector(".longitude");
    const latitude = tableElement.querySelector(".latitude");
    map.setCenter([longitude.textContent,latitude.textContent]);
    console.log(longitude.textContent,latitude.textContent,"<br",map.getCenter());
  });
});
