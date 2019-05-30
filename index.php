<?php
/**
 * Copyright 2017 PHPAS2
 *
 * PHP Version ~5.6.5|~7.0.0
 *
 * @author   Brett <bap14@users.noreply.github.com>
 */

?>
<html>
<head>
    <title>PHPAS2 Demo</title>
</head>
<body>
    <h1>PHPAS2 Demo Site</h1>
    <p>This is a site to demonstrate the PHPAS2 library in a framework agnostic pure-PHP system.</p>
    <p>
    </p>
    <h2>PHPAS2 Client</h2>
    <p>To send a test message to a test AS2 server, just select a partner from the list below and click "Send".</p>
    <form action="client.php" method="post">
        <p>
            <label for="partner">AS2 Partner From</label>
            <?php
            $partnersDir = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/phpas2/phpas2/partners';
            $dirList = scandir($partnersDir);
            $partners = [];
            foreach ($dirList as $dir) {
                if ($dir == '.' || $dir == '..' || $dir == '.DS_Store') {
                    continue;
                }

                $config = include(
                    $partnersDir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'config.php'
                );

                if ($config['is_local'] === true) {
                    
                    $partners[$config['id']] = $config;
                }
            }
            ?>
            <select name="as2from">
                <?php
                foreach ($partners as $partnerConfig) {
                    ?>
                    <option value="<?php echo $partnerConfig['id']; ?>"><?php echo $partnerConfig['name']; ?></option>
                    <?php
                }
                ?>
            </select>
        </p>
        <p>
            <label for="partner">AS2 Partner To</label>
            <?php
                $partnersDir = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'vendor/phpas2/phpas2/partners';
                $dirList = scandir($partnersDir);
                $partners = [];
                foreach ($dirList as $dir) {
                    if ($dir == '.' || $dir == '..' || $dir == '.DS_Store') {
                        continue;
                    }

                    $config = include(
                        $partnersDir . DIRECTORY_SEPARATOR . $dir . DIRECTORY_SEPARATOR . 'config.php'
                    );

                    if ($config['is_local'] === false) {
                        $partners[$config['id']] = $config;
                    }
                }
            ?>
            <select name="as2to">
                <option value=""></option>
                <?php
                    foreach ($partners as $partnerConfig) {
                        ?>
                        <option value="<?php echo $partnerConfig['id']; ?>"><?php echo $partnerConfig['name']; ?></option>
                        <?php
                    }
                ?>
            </select>
        </p>
        <p><button type="submit">Send</button></p>
    </form>

    <h2>PHPAS2 Server</h2>
    <p>
        To send a test message to this server, you will send a POST message to:
        <code><?php echo $_SERVER['HTTP_HOST']; ?></code> with the following configuration:
    </p>
    <ul>
        <li><strong>AS2 ID:</strong> phpas2demo</li>
        <li><strong>Message Encryption Method:</strong> Triple-DES (3DES)</li>
        <li><strong>Message Signed:</strong> Yes</li>
        <li><strong>Message Signature Algorithm:</strong> SHA1</li>
        <li><strong>MDN Type:</strong> Synchronous</li>
        <li><strong>MDN Signed:</strong> Yes</li>
        <li><strong>MDN Signature Algorithm:</strong> SHA1</li>
        <li><strong>Encryption Certificate:</strong> <pre>-----BEGIN CERTIFICATE-----
MIIHNTCCBR2gAwIBAgIIOSZCSPmWVMUwDQYJKoZIhvcNAQELBQAwbDELMAkGA1UE
BhMCRVMxFDASBgNVBAoMC1N0YXJ0Q29tIENBMSkwJwYDVQQLDCBTdGFydENvbSBD
ZXJ0aWZpY2F0aW9uIEF1dGhvcml0eTEcMBoGA1UEAwwTU3RhcnRDb20gQlIgU1NM
IElDQTAeFw0xNzA3MjExMjUyMTdaFw0xOTA3MjEwNTAyMDBaMCYxCzAJBgNVBAYT
AlVTMRcwFQYDVQQDDA5kZW1vLnBocGFzMi51czCCASIwDQYJKoZIhvcNAQEBBQAD
ggEPADCCAQoCggEBAKUm6QKFyy0/jpss2FYF0OljKcdeCR+OfV4Qxqn/cFmi9ty4
7jbLD7DozmDS2Ml4XaTTI/Go4EVi5rKX5eqGu90qMvh87hJjV0ehqwmdDQEkJNoA
AsWzpgSHAtqCHuOORraUdmG9NVfuWpsJpiuxyt3algmIGbjAetAPGVNg3bvtb8n5
XFkxORaknh1OPFemjWLAez4liB4JNlaD8zAF1EwKTb7aLFZP+QjEi/QkiDSW5XuC
WbkctAKoj65MVUV/Oc6tVZxhjizVA09czC1+fM96MhFRKEqrgrVSHDMQIfJNCeNR
hgBSQQySfu/bVRtkXb0v5XaaUTBohqrvWoFl0IUCAwEAAaOCAx8wggMbMHMGCCsG
AQUFBwEBBGcwZTA7BggrBgEFBQcwAoYvaHR0cDovL2FpYS5zdGFydGNvbWNhLmNv
bS9jZXJ0cy9zY2Euc2VydmVyMS5jcnQwJgYIKwYBBQUHMAGGGmh0dHA6Ly9vY3Nw
LnN0YXJ0Y29tY2EuY29tMB0GA1UdDgQWBBSqJz4qJ2fgMUK80AZpZDp+fZ8z5DAJ
BgNVHRMEAjAAMB8GA1UdIwQYMBaAFPsQS5WxNVUvvWIUqVICEgpo6BJCMFIGA1Ud
IARLMEkwDQYLKwYBBAGBtTcBAgMwOAYGZ4EMAQIBMC4wLAYIKwYBBQUHAgEWIGh0
dHA6Ly93d3cuc3RhcnRjb21jYS5jb20vcG9saWN5MDoGA1UdHwQzMDEwL6AtoCuG
KWh0dHA6Ly9jcmwuc3RhcnRjb21jYS5jb20vc2NhLXNlcnZlcjEuY3JsMA4GA1Ud
DwEB/wQEAwIFoDAdBgNVHSUEFjAUBggrBgEFBQcDAgYIKwYBBQUHAwEwGQYDVR0R
BBIwEIIOZGVtby5waHBhczIudXMwggF9BgorBgEEAdZ5AgQCBIIBbQSCAWkBZwB1
ADS7atbD35wD7qikmf94kUhsnV5crJLQH3v9G84Z20jvAAABXWU92GgAAAQDAEYw
RAIgQ2CSo22jdPAfYMLJNBkXjEiBVSzgD2U8DF/xIRksCm0CIGDLpan78G4xKx4o
7xmWpCUlnBodOnGTXXJAijn7wzgeAHcApLkJkLQYWBSHuxOizGdwCjw1mAT5G9+4
43fNDsgN3BAAAAFdZT3XDgAABAMASDBGAiEA7nAo92kVKjcgipTjczCtNe2fqFvp
qP8d2EEZ81O4umMCIQCQVzohc/mP3GzUbUSGG1m4XXLop+SiWOvUlUOeFEqf8QB1
AO5Lvbd1zmC64UJpH6vhnmajD35fsHLYgwDEe4l6qP3LAAABXWU92fcAAAQDAEYw
RAIgMHWgc60mkl0s2lImkvuQD3Ur+Iuz25u6+PADgtmUdjICIDROUgPdpSnUD938
G6KhVjBNDuavGIMYfphUbbqXlZtzMA0GCSqGSIb3DQEBCwUAA4ICAQCBoXvgpl4k
7UZ5k1YFdqvej7O63G0hmPkFJxYH3CcBqbC+UEo/RibJj6eVljzNIH5jFCSHtvKA
tIgekvsrTTI15zb52c0kOZqR2WieG5fbDrWLHjOWlLx5z2va208iCChrrZkmu1zq
OOlGgv3c+Bl6vnOS7nrwPe7r6LGE3c8qlWlEw4zDtdvapMIDyKfWgjA/9fdRrHZ2
JFFA7Cgpw1lojShzEOPVe8RKKEYlhgU8SCWlV6DPHGbfuGnovbZXlpMSF7IOWx+Y
Ml4iwf7Hq81CWdsdQlrDSMhWCWr4y0rvUBj1lwzYqcCsd17Htseh+cA0jIENsbEJ
kiB72nclBdqB7/J3x8LHmUBj/UcYAplumP+BgQmmeQVSVNRtyzcKCS8ZmoZCo7AO
wXtAmWAqB+YrGZBJctVxg3f/lndQivCV+YITDoc3FfOif/F7faMsB8YDzBB6HmkD
LxHJTl3srq9UdalBRl9Xj8DBh10kSSiMDOk5QxA2ANPPz2MeGoCzYhv9xsnCL/3k
6kjao4SpTkkVylOi6DKGU3A8FIQD8iSBVad2SdMu1ow5kDNaD/6LDRPOUl5uO3QS
w+AJ4nFMEP2Aqcoqgbo38R0uIyrm3NPrqpTYmIySI4vGoyAK9B/BMYheUeD9nK1X
vPTz3YNpTvsZEqd7bKoN0tyUvxDMknGWng==
-----END CERTIFICATE-----</pre></li>
    </ul>
</body>
</html>
