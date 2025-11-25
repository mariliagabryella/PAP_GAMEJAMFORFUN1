<?php
// Array associativo contendo redes sociais e seus respectivos ícones + links
$socials = [
    "YouTube" => ["https://www.youtube.com/@GAMEJAM2024-AEAAV", "fa-brands fa-youtube"],
    "Instagram" => ["https://www.instagram.com/tgpsi_aeaav/", "fa-brands fa-instagram"],
    "TikTok" => ["https://www.tiktok.com/@gamejam_aeaav", "fa-brands fa-tiktok"],
   // "LinkedIn" => ["https://www.linkedin.com", "fa-brands fa-linkedin"],
   // "Tumblr" => ["https://www.tumblr.com", "fa-brands fa-tumblr"],
    //"Twitter" => ["https://www.twitter.com", "fa-brands fa-twitter"],
    //"Twitch" => ["https://www.twitch.tv", "fa-brands fa-twitch"],
   // "Discord" => ["https://www.discord.com", "fa-brands fa-discord"]
];

// Gera os ícones dinamicamente
foreach ($socials as $name => [$url, $icon]) {
    echo "<a href='$url' target='_blank'><i class='$icon'></i></a>";
}
?>
