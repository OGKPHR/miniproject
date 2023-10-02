<?php
if (extension_loaded('oci8')) {
    echo 'OCI8 extension is enabled.';
} else {
    echo 'OCI8 extension is not enabled.';
}