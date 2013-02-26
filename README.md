Gists
-----

A simple PHP class that provides an easy interface for gists GitHub.

Usage
-----

    require_once('src/gists.class.php');

    $obj = new Gist();

    $resp = json_decode($obj->all($user),true);

    print_r($resp);