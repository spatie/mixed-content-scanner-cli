<?php

return '

Start scanning http://localhost:9000/ for mixed content
=======================================================

http://localhost:9000/: ok
http://localhost:9000/noMixedContent: ok
http://localhost:9000/mixedContent: found mixed content on element img with url http://mixed-content-image.jpg/
http://localhost:9000/brokenLink: ok
http://localhost:9000/noResponse: ok

Scan results
============

Found 1 pieces of mixed content
 * http://localhost:9000/mixedContent: found mixed content on element img with url http://mixed-content-image.jpg/

Found 4 pages without mixed content

';
