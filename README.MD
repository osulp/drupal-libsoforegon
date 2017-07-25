# Libraries of Oregon - Drupal 7
An as-is port of the D6 version to D7, moving the custom geolocation and library search functionality into Drupal modules and/or theme files to get rid of PHP in nodes and custom, standalone script files.

### Modules:
- ctools
- feeds
- google_analytics
- job_scheduler
- linkchecker
- node_export
- quicktabs
- smart_ip
- uuid
- views
- wysiwyg

### Custom:
- diigo_links
- loo_geolocate

### Theme:
- loo: A fixed-width 980px theme adapted from the "Simple Corporate" theme from [Devsaran](http://www.devsaran.com)

### Geolocation
Geolocation-based functionality accomplished through the custom module **LoO Geolocate**, which in turn uses the [Smart IP](https://www.drupal.org/project/smart_ip) module to determine whether a user is permitted to view restricted content. Smart IP uses the Maxmind GeoIP2 web service to attempt to determine whether the user is accessing the site from a computer within the state of Oregon and if so, allows the user to view restricted content.

### Find a Library
Uses the [Feed Import](https://www.drupal.org/project/feed_import) module to import a CSV list of libraries from the [Oregon State Library Directory](http://libdir.osl.state.or.us/export.php?search_string=&search_filter=&sort=) into a custom content type. Two taxonomy vocabularies, **Oregon Library Cities** and **Oregon Library Counties** are used to drive search by city and search by county views of the **Oregon Library** nodes.

### Browse Topics / Jobs Resources
The custom module **Diigo Links** reads link categories and data from the Diigo site at https://www.diigo.com/user/Plinkit-or.
