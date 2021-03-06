<?php
add_filter('smilies_src','custom_smilies_src',1,10);
function custom_smilies_src ($img_src, $img, $siteurl){
    return get_template_directory_uri() . '/images/smilies/'.$img;
}
function disable_emojis_tinymce( $plugins ) {
    return array_diff( $plugins, array( 'wpemoji' ) );
}
function smilies_reset() {
    global $wpsmiliestrans, $wp_smiliessearch, $wp_version;
    if ( !get_option( 'use_smilies' ) || $wp_version < 4.2)
        return;
    $wpsmiliestrans = array(
		"#(afraid)" => "afraid.png",
		"#(ahh)" => "ahh.png",
		"#(alian)" => "alian.png",
		"#(angel)" => "angel.png",
		"#(angelman)" => "angelman.png",
		"#(angry)" => "angry.png",
		"#(arrogant)" => "arrogant.png",
		"#(arrow)" => "arrow.png",
		"#(badman)" => "badman.png",
		"#(biggrin)" => "biggrin.png",
		"#(biggrin)" => "biggrin.png",
		"#(bigsmalleyes)" => "bigsmalleyes.png",
		"#(bigsmile)" => "bigsmile.png",
		"#(boom)" => "boom.png",
		"#(bowknot)" => "bowknot.png",
		"#(bye)" => "bye.png",
		"#(cake)" => "cake.png",
		"#(catarrow)" => "catarrow.png",
		"#(catgrin)" => "catgrin.png",
		"#(cathappy)" => "cathappy.png",
		"#(catlol)" => "catlol.png",
		"#(catrazz)" => "catrazz.png",
		"#(catrolleyes)" => "catrolleyes.png",
		"#(catserious)" => "catserious.png",
		"#(catsurprised)" => "catsurprised.png",
		"#(cattear)" => "cattear.png",
		"#(clown)" => "clown.png",
		"#(confuse)" => "confuse.png",
		"#(confused)" => "confused.png",
		"#(cool)" => "cool.png",
		"#(cough)" => "cough.png",
		"#(covermouthlaugh)" => "covermouthlaugh.png",
		"#(cowboy)" => "cowboy.png",
		"#(cry)" => "cry.png",
		"#(despise)" => "despise.png",
		"#(determination)" => "determination.png",
		"#(dissatisfied)" => "dissatisfied.png",
		"#(drool)" => "drool.png",
		"#(eek)" => "eek.png",
		"#(eh)" => "eh.png",
		"#(embarrassed)" => "embarrassed.png",
		"#(evil)" => "evil.png",
		"#(exclaim)" => "exclaim.png",
		"#(flirt)" => "flirt.png",
		"#(ghost)" => "ghost.png",
		"#(gift)" => "gift.png",
		"#(grin)" => "grin.png",
		"#(happy)" => "happy.png",
		"#(happykiss)" => "happykiss.png",
		"#(headache)" => "headache.png",
		"#(hu)" => "hu.png",
		"#(hum)" => "hum.png",
		"#(hunger)" => "hunger.png",
		"#(icecream)" => "icecream.png",
		"#(idea)" => "idea.png",
		"#(ill)" => "ill.png",
		"#(kiss)" => "kiss.png",
		"#(laughdown)" => "laughdown.png",
		"#(laughing)" => "laughing.png",
		"#(lie)" => "lie.png",
		"#(lol)" => "lol.png",
		"#(mad)" => "mad.png",
		"#(money)" => "money.png",
		"#(monkeyshut)" => "monkeyshut.png",
		"#(mrgreen)" => "mrgreen.png",
		"#(naughty)" => "naughty.png",
		"#(nervous)" => "nervous.png",
		"#(neutral)" => "neutral.png",
		"#(no)" => "no.png",
		"#(odd)" => "odd.png",
		"#(oh)" => "oh.png",
		"#(perspire)" => "perspire.png",
		"#(pokerfaced)" => "pokerfaced.png",
		"#(question)" => "question.png",
		"#(quiteafraid)" => "quiteafraid.png",
		"#(quitesad)" => "quitesad.png",
		"#(razz)" => "razz.png",
		"#(redface)" => "redface.png",
		"#(robot)" => "robot.png",
		"#(rolleyes)" => "rolleyes.png",
		"#(sad)" => "sad.png",
		"#(saisfied)" => "saisfied.png",
		"#(salvo)" => "salvo.png",
		"#(scared)" => "scared.png",
		"#(search)" => "search.png",
		"#(serious)" => "serious.png",
		"#(shh)" => "shh.png",
		"#(shit)" => "shit.png",
		"#(skeleton)" => "skeleton.png",
		"#(smile)" => "smile.png",
		"#(sneeze)" => "sneeze.png",
		"#(snivel)" => "snivel.png",
		"#(sour)" => "sour.png",
		"#(speechless)" => "speechless.png",
		"#(star)" => "star.png",
		"#(stare)" => "stare.png",
		"#(stupid)" => "stupid.png",
		"#(surprised)" => "surprised.png",
		"#(tear)" => "tear.png",
		"#(tongue)" => "tongue.png",
		"#(tonuge)" => "tonuge.png",
		"#(twisted)" => "twisted.png",
		"#(unconfortable)" => "unconfortable.png",
		"#(unhappy)" => "unhappy.png",
		"#(verysad)" => "verysad.png",
		"#(vomit)" => "vomit.png",
		"#(warm)" => "warm.png",
		"#(wink)" => "wink.png",
		"#(yama)" => "yama.png",
		"#(zipper)" => "zipper.png",
		"#(zzz)" => "zzz.png",
    );
}
smilies_reset();
?>