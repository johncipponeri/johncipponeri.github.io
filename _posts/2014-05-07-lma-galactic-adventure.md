---
layout: post
title: Let's Make a Galactic Adventure!
description: "Guide to creating a randomly generated space-themed game using HaxeFlixel."
tags: [tutorial, code, gamedev, space, adventure, galactic]
image:
  feature: drifter-header.png
comments: true
---

<section id="table-of-contents" class="toc">
  <header>
    <h3 >Sections</h3>
  </header>
<div id="drawer" markdown="1">
*  Auto generated table of contents
{:toc}
</div>
</section><!-- /#table-of-contents -->

This guide is directed at those of you that are still learning to code, use HaxeFlixel or just want to see what went into making my game, Drifter. We will be taking an inside look at each step I had to take in developing this game from assets to programming, as well as why I made those decisions. Everything will be explained as simply as I can put it to appeal to all audiences. This guide was written to demonstrate what goes into making a small scale game such as this one, as well as to reinforce numerous game mechanics such as:

* Using HaxeFlixel Addons
* FlxWeapon, FlxFlicker, FlxBackdrop, etc
* Simple Enemy AI
* Random Enemy Spawning
* Generate Fonts

These are the primary learning targets for this guide and are what make up a good portion of this project. We will learn, explore, and put to use these mechanics and various other things that HaxeFlixel has to offer. By using what we have available we will be remaking Drifter from scratch!

## Play the Game

If you'd like to see what we'll be recreating you can click the button below to play the game. We will be creating an exact replica step-by-step taking an in-depth look at the development process I took to create it. You may also view the public source code. Our goal is to re-write the entire game from nothing mimicking the original source.

<div markdown="0"><a href="http://johncipponeri.github.io/drifter/index.swf" class="btn btn-info">Play the Game</a> 
<a href="http://github.com/johncipponeri/drifter" class="btn btn-info">View the Source</a></div>

## First Steps

Now when developing a game you have a few preliminary steps to take. The first of which is to come up with a game! However lucky for you I've already done that part. We will be recreating Drifter, a top down space shooter. Now when making a game that's not really much to go off of.

<figure>
	<img src="http://placehold.it/600x300.jpg">
	<figcaption>Original Drifter Concept.</figcaption>
</figure>

This is the original idea I had for Drifter. I had planned for there to be a single player ship at the bottom who can only move left or right. From this position they can shoot and evade enemy projectiles and objects. From the top there were to be randomly spawned enemies such as asteroids and ships who would collide into you or could be destroyed by your laser. I also wanted to include an epic boss battle to finish off the first iteration of the game. You would have a score and achieve the boss battle after destroying X amount of enemies. The core idea behind the game is to be extensible by adding in achievable bosses as you fight an onslaught of enemies coming at increasing rates. This allows for us to always add just 1 more boss and as many enemies as we like.

## Artwork

<figure class="third">
	<img src="/images/drifter-playerbase.png">
	<img src="/images/drifter-ufo.png">
	<img src="/images/drifter-enemyship.png">
</figure>

<br/>

I am a one man army with no digital artistic talent whatsoever. So I had to limit my game idea to use a very small amount of artwork that I would have to find online that is free to use. Well considering this fact, the chances of finding a set of artwork that looks good together and contains a enemy mothership, space ship, asteroids, and lasers was very slim. So after some hunting I would eventually use instead. You can download the assets below.

<div markdown="0"><a href="http://opengameart.org/content/space-shooter-redux" class="btn btn-info">Download the Assets</a></div>

**Pro-tip:** This is an updated version of the graphics I originally found. The artist who created this assets has added a lot more than I had originally found. I separated each graphic into it's own sprite as well. You can use Github to check the exact assets.
{: .notice}

## Sounds & Music

I also created my own sound effects which are free for anyone to use. They are both in the Drifter Github repository and available to download below along with the free to use Music I had to find online. When creating the sound effects I decided to use Bfxr, a very simple sound generating tool used widely for games in rapid development. I wanted simple yet identifiable sounds and Bfxr provided me with what I needed. As for music I needed something engaging as well as non-repetitive on your ears since you will hear this for majority of the game. I was luckily able to find two tracks that went together, as well as suited my needs from PlayOnLoop. The second track is used during the boss battle to get things pumped up.

<div markdown="0"><a href="#" class="btn btn-info">Download the Sounds</a> 
<a href="http://www.playonloop.com/music-loops-category/videogame/" class="btn btn-info">Download the Music</a></div>

**Pro-tip:** The tracks used were 'Twin Turbo' and 'Cyber Soldier'.
{: .notice}

## Creating the Project

Now that we have our artwork for the enemies, player, and backgrounds, as well as sound effects and background music we can start putting it all together! But first things first we need to create our project to organize and maintain our game. To do this with HaxeFlixel installed I open up my command prompt and type:

{% highlight bash %}
flixel tpl -n "drifter"
{% endhighlight %}

Now that we have our project created we have a few directories available to use. In `assets/images/` we can place our artwork. We also have `assets/sounds/` and `assets/music/` that we can dump our music and sound effects into for use by the game. So far we have accomplished defining the generic mechanics and gameplay of our game, and the assets we will be using. These are some humongous steps in starting the development of our game, and you should be proud. From here we can begin putting everything together and giving life to our assets one milestone at a time. Considering this is only the first iteration of the game and there are so many assets available we can add on as much as we like.

---

Now that our project is setup we can take a look at the source files that have been generated. These source files are what contain the games code. The code is then translated to any of the various platforms HaxeFlixel supports. But in this case we'll be using Flash, a very popular and widely installed platform that requires little to no extra steps to use. We currently have a couple of files in our project.

## Project Structure

{% highlight text %}
drifter/
├── source/
|    ├── AssetPaths.hx #
|    ├── Main.hx       # The game's entry-point
|    ├── MenuState.hx  # The code used for the main menu
|    ├── PlayState.hx  # The code used for the playstate
|    └── Reg.hx        # Code used for global variables
├── assets/
|    ├── data/         # Directory for save files, etc
|    ├── images/
|    ├── music/
|    └── sounds/
└── Project.xml        # Config for game properties
{% endhighlight %}

Each folder in our project has a specific task and use. The source folder contains all of our source files, but there are some that were automatically generated that are not necessary for this game. You do not *have* to but I do recommend deleting the files `AssetPaths.hx`, and `Reg.hx` simply because we will not be using them. At this rate you can also delete the `assets/data/` directory since we will not be using it either. Now that your project structure is all cleaned up, we can explore the files we *will* be using.

## Meeting the Source

<h4>Main</h4>

We have a source file titled Main. This file contains all the code of which HaxeFlixel uses to initially start our game and set up the container, whether it be a window or something else related to your targeted platform(s). You will often rarely touch anything here besides some properties such as the size and title of the container for your game, as well as the option to skip the HaxeFlixel splash screen or set your game to fullscreen. This is just one of those little things HaxeFlixel magically takes care of for you.

<h4>MenuState</h4>

HaxeFlixel uses what is commonly referred to as a 'State Machine' this allows us to break our game up into states, or different screens and menus such as the Main, and Options menus as well as the primary game screen. This Menu state is automatically generated and is the first screen the `Main.hx` source file tells the game to go to. You can change this to any other state you've created by going into the `Main.hx` source file and editing this line:

{% highlight haxe %}
var initialState:Class<FlxState> = YourState;
{% endhighlight %}

`YourState` is now the screen that will be shown when the game starts. We will not be creating any states that weren't already generated in this project.

<h4>PlayState</h4>

Another state that has been generated, this state is meant to be used as your primary state where all the action takes place. We will be working here the most. This is where we will be glueing everything together.

## Main Menu

Since our game starts at the MenuState we should really consider adding something to it besides the blank screen it currently is! Since this game is relatively simple all we will be adding is background, title, and play button. Now the cool thing about HaxeFlixel is it comes with a default skin for things like buttons so prototyping a UI is as simple as can be. To start let's open our `MenuState.hx` source file.


/***** TALK ABOUT ADDONS */

{% highlight haxe %}
package;

import flixel.FlxG;
import flixel.FlxState;
import flixel.text.FlxText;
import flixel.ui.FlxButton;
import flixel.util.FlxColor;
import flixel.addons.display.FlxBackdrop;

class MenuState extends FlxState
{
	override public function create():Void
	{
		super.create();
	}

	override public function destroy():Void
	{
		super.destroy();
	}
}
{% endhighlight %}

This is our barebones MenuState, pretty boring isn't it? So let's add some flair! At the top you'll see the imported classes we'll using from HaxeFlixel. By importing them we are permitted to use them throughout our class. You'll also notice the create and destroy methods. These are used by HaxeFlixel to setup and tear down your State. We will be using create to initialize our variables and destroy to nullify them. So first things first we should add our background!

<h4>Background</h4>

{% highlight haxe %}
private var background:FlxBackdrop;

override public function create():Void
{
	super.create();

	background = new FlxBackdrop("assets/images/background.png");
	background.setVelocity(100, 100);

	add(background);
}

override public function destroy():Void
{
	super.destroy();

	background = null;
}
{% endhighlight %}

As you can see we created a parallax background using `FlxBackdrop`. This class allows us to use an image of any size, fill the screen with it, and then give it a velocity that will cause the image to move and loop on the screen. Thus we have our parallax background moving at 100 pixels on the X and Y axis, in a down-right direction. Right after initializing and giving our background it's parallax abilities we add it to the State. By using the `add` function we actually make our background visible in the game, and last but not least in our `destroy` function we set our background to null. Now that we have the background done, it is time to move onto the title! Lucky for HaxeFlixel provides an easy way to do this as well.

<h4>Title</h4>

{% highlight haxe %}
private var background:FlxBackdrop;
private var title:FlxText;

override public function create():Void
{
	super.create();

	background = new FlxBackdrop("assets/images/background.png");
	background.setVelocity(100, 100);

	title = new FlxText(0, 20, FlxG.width, "DRIFTER");
	title.setFormat(null, 48, FlxColor.WHITE, "center");
	title.setBorderStyle(FlxText.BORDER_OUTLINE, FlxColor.BLACK, 2);

	add(background);
	add(title);
}

override public function destroy():Void
{
	super.destroy();

	background = null;
	title      = null;
}
{% endhighlight %}

Hold on just a minute, that doesn't look so easy! Ah, but it is. Just like the `background` we created a `title` variable using the `FlxText` class. `FlxText` allows us to generate a graphically represented word or phrase, in this case the title of our game.

{% highlight haxe %}
title = new FlxText(0, 20, FlxG.width, "DRIFTER");
{% endhighlight %}

To create the `title` we apply an (X, Y) coordinate pair of (0, 20). In HaxeFlixel the coordinate system begins in the top left at (0, 0), and all objects like our title on the game's coordinate plane are positioned based on their top left pixel. This means that the top left pixel of our title is at (0, 20) and the rest of it automatically positions itself from that point. 

{% highlight haxe %}
title.setFormat(null, 48, FlxColor.WHITE, "center");
{% endhighlight %}

Besides positioning we also give the title a width the same size of the window. This width applies to the imaginary box surrounding the title, sort of like a text field. We do this so that we can center the title based on the window's size. This centering is done via the `setFormat` function. The first parameter we give the function is `null` for the font. By passing `null` instead of a proper value HaxeFlixel uses the default font `nokiafc22`. Next we give a font size of 48, a text color of `WHITE` supplied by the `FlxColor` class, and we align the text to the `"center"` of it's imaginary box. These values are just what I decided looked good.

{% highlight haxe %}
title.setBorderStyle(FlxText.BORDER_OUTLINE, FlxColor.BLACK, 2);
{% endhighlight %}

To add the border to our title we used `FlxText`'s `setBorderStyle` function. `FlxText` offers a few options for borders, but I ultimately decided on using `BORDER_OUTLINE` colored `BLACK` with a width of 2. Once again these are just the choices I made to stylize the title. They can be easily configured to your liking with a variety of different options.

<h4>Play Button</h4>

{% highlight haxe %}
private var background:FlxBackdrop;
private var title:FlxText;
private var btnPlay:FlxButton;

private function onClickPlay()
{
	FlxG.switchState(new PlayState());
}

override public function create():Void
{
	super.create();

	background = new FlxBackdrop("assets/images/background.png");
	background.setVelocity(100, 100);

	title = new FlxText(0, 20, FlxG.width, "DRIFTER");
	title.setFormat(null, 48, FlxColor.WHITE, "center");
	title.setBorderStyle(FlxText.BORDER_OUTLINE, FlxColor.BLACK, 2);

	btnPlay = new FlxButton(FlxG.width / 2, FlxG.height / 2, "PLAY!", onClickPlay);
	btnPlay.x -= btnPlay.width / 2;

	add(background);
	add(title);
	add(btnPlay);
}

override public function destroy():Void
{
	super.destroy();

	background = null;
	title      = null;
	btnPlay    = null;
}
{% endhighlight %}

We're coming to an end with our Main menu, and only have a few things left to add. However the most important of these things is giving the player a way to actually start the game! Thus we have the play button.

{% highlight haxe %}
btnPlay = new FlxButton(FlxG.width / 2, FlxG.height / 2, "PLAY!", onClickPlay);
{% endhighlight %}

Once again we're using another magical Flx class. The `FlxButton` class allows us to create an interactive game element that represents a common button. In this case we set the position of the button's top left pixel to be in the exact middle of our window. The math is quite simple. Next we specify the text we wish to display on our button, in this case `"PLAY!"`. The text is what determines the width and height of the button itself. The last parameter is the trickiest. This is the name of the function we want to have executed when the button is pressed.

{% highlight haxe %}
private function onClickPlay()
{
	FlxG.switchState(new PlayState());
}
{% endhighlight %}

When executed, this function will tell HaxeFlixel that we are done with this state and want to display another. So when the play button is clicked `PlayState` becomes the center of attention.

<h4>Finishing Up</h4>

Now we have a fully functional main menu! Complete with a fancy parallax background, generated title, and play button. What else could we possibly need? *Music*. No menu, or game for that matter is complete without music!

{% highlight haxe %}
override public function create():Void
{
	super.create();

	background = new FlxBackdrop("assets/images/background.png");
	background.setVelocity(100, 100);

	title = new FlxText(0, 20, FlxG.width, "DRIFTER");
	title.setFormat(null, 48, FlxColor.WHITE, "center");
	title.setBorderStyle(FlxText.BORDER_OUTLINE, FlxColor.BLACK, 2);

	btnPlay = new FlxButton(FlxG.width / 2, FlxG.height / 2, "PLAY!", onClickPlay);
	btnPlay.x -= btnPlay.width / 2;

	add(background);
	add(title);
	add(btnPlay);

	FlxG.sound.playMusic("assets/music/background.wav", 0.35);
}
{% endhighlight %}

The `FlxG` class gives us the power to play music on a loop on command! However I found the music to be too loud so I also specified `0.35` to set the volume level of the music itself to about 35% of it's normal. The best apart about music in HaxeFlixel is that it never stops playing until you tell it to! So even though we started playing the music on this state, any other state we switch to will still be playing this music without a stutter!

## The Player

Now it's time we finally give our player a face of their very own! Or in this case a ship. We'll be creating the class that will dictate the properties and actions of our player in the game world.

{% highlight haxe %}
package;

import flixel.FlxG;
import flixel.FlxSprite;
import flixel.addons.weapon.FlxWeapon;

class Player extends FlxSprite
{
	public function new()
	{

	}

	override public function update()
	{

	}
}
{% endhighlight %}

Once again this is our barebones player class. The player is a `FlxSprite` which allows us to give it a position on the screen, a graphic, health, and whatever else we decide to add! The `FlxSprite` class is very versatile. We're going to be using two new functions, `new` and `update`. As you can recall we used the `create` function when doing the `MenuState`. HaxeFlixel uses these functions in the background, we just feed it the instructions we need. So for `FlxState` classes HaxeFlixel uses the `create` function to initialize our variables and create a new state. `FlxSprite` on the other hand like most other HaxeFlixel classes use the `new` function to do the same thing. Since we are extendings a `FlxSprite` we must also apply the properties a `FlxSprite` requires to be used.

{% highlight haxe %}
public function new()
{
	super(FlxG.width / 2 - 50, FlxG.height - 100, "assets/images/player_base.png");
}
{% endhighlight %}

By using the function `super` we are technically executing the `FlxSprite`'s own `new` function. By doing so we give our player a position, as well as a graphic. In this case we are centering the player on the bottom of the screen. `FlxG.width / 2 - 50` gives us the middle X coordinate of the screen and subtracts `50`, or half the width of the graphic we're using to center the player on the X-axis. For the Y we are using `FlxG.height - 100` to get the very bottom of the screen and shift it up by the height of our graphic. This is just simple math used to find the position we want and offset it with our graphics dimensions. We do it this way because if you recall HaxeFlixel's coordinate plane starts at (0, 0) in the top-left corner of the screen. Also many objects we display in the game are positioned based on their top left pixel. If we shift that top left pixel from the center we are actually positioning the entire graphic. Now let's give the player the ability to move their ship left and right.

{% highlight haxe %}
override public function update()
{
	super.update();

	velocity.x = 0;

	if (FlxG.keys.anyPressed(["A", "LEFT"]))
		velocity.x -= 200;
	else if (FlxG.keys.anyPressed(["D", "RIGHT"]))
		velocity.x += 200;
}
{% endhighlight %}

Our player being a `FlxSprite` has a velocity. HaxeFlixel uses this velocity's X and Y value to constantly move the sprite.

{% highlight haxe %}
velocity.x = 0;
{% endhighlight %}

Since our `update` function is executed 60 times per second we reset our velocity on the x-axis to 0 so that when the player is no longer holding the button he will stop, or if he is still holding the button the velocity will not exceed the range of -200 to 200 since we are constantly resetting it back to 0 after changing it. 200 is just the speed I found that looked good after testing multiple other values.

{% highlight haxe %}
if (FlxG.keys.anyPressed(["A", "LEFT"]))
	velocity.x -= 200;
else if (FlxG.keys.anyPressed(["D", "RIGHT"]))
	velocity.x += 200;
{% endhighlight %}

We use `FlxG.keys.anyPressed` to poll whether or not either of the keys specified are currently being pressed, and if they are we change the velocity accordingly. A negative velocity moves us to the left, and a positive to the right. But what about a weapon?

{% highlight haxe %}
public var gun:FlxWeapon;

public function new()
{
	super(FlxG.width / 2 - 50, FlxG.height - 100, "assets/images/player_base.png");

	gun = new FlxWeapon("gun", this);
	gun.makeImageBullet(50, "assets/images/laser_green.png");
	gun.setFireRate(200);
	gun.setBulletSpeed(200);
	gun.setBulletOffset(width / 2 - 4, 0);
}
{% endhighlight %}

Here we create a `FlxWeapon` called gun. The `FlxWeapon` class provides us with a simple way to give our player projectile weaponry. We have the `gun` defined as `public` so in the future you could potentially change the players weapon via power ups or any other means.

{% highlight haxe %}
gun = new FlxWeapon("gun", this);
{% endhighlight %}

When we initialize the weapon we specify some of the things required by the `FlxWeapon`. We give the gun a name in case we need to reference it in the future, as well as a reference the player. `FlxWeapon` uses this reference to align the weapon's graphic and the position of which to shoot from based on the position of the player.

{% highlight haxe %}
gun.makeImageBullet(50, "assets/images/laser_green.png");
{% endhighlight %}

Since we have a fantastic laser asset we use the `makeImageBullet` function to provide the gun with a graphic to use for the projectiles it fires. We specify the number `50` because it's a rough estimate of how many bullets we will have on the screen at once, however this isn't even close it's always good to slightly overestimate.

{% highlight haxe %}
gun.setFireRate(200);
gun.setBulletSpeed(200);
{% endhighlight %}

Now we use the `setFireRate` and `setBulletSpeed` functions to set the velocity of which the projectiles will fly across the screen in terms of pixels per second, as well as how much time in milliseconds we should wait before allowing the gun to fire again. With the speed being `200` milliseconds we are allowing the player to shoot 5 times per second.

{% highlight haxe %}
gun.setBulletOffset(width / 2 - 4, 0);
{% endhighlight %}

This last bit of code sets the bullets position of origin, or where it starts at when it's initially fired to be in the middle of the player. We calculate this by dividing the players width and subtracting half the width of the projectile graphic, so `width / 2 - 4` provides us with just this. By specifying `0` as the inital Y coordinate we are position the bullet at the top of the player's graphic.

{% highlight haxe %}
override public function update():Void
{
	super.update();

	velocity.x = 0;

	if (FlxG.keys.anyPressed(["A", "LEFT"]))
		velocity.x -= 200;
	else if (FlxG.keys.anyPressed(["D", "RIGHT"]))
		velocity.x += 200;

	if (FlxG.keys.anyJustPressed(["SPACE"]))
	{
		FlxG.sound.play("assets/sounds/shoot.wav");
		gun.fireAtPosition(Std.int(x + width / 2) - 1, 0);
	}
}
{% endhighlight %}

Now we give the player a fancy weapon but what we forgot to do was show them how to use it! By polling the input again we can allow them to shoot with the space bar.

{% highlight haxe %}
if (FlxG.keys.anyJustPressed(["SPACE"]))
{
	FlxG.sound.play("assets/sounds/shoot.wav");
	gun.fireAtPosition(Std.int(x + width / 2) - 1, 0);
}
{% endhighlight %}

Complete with a nice sound effect we can now fire our weapon! By telling the `gun` to `fireAtPosition` we can specify that the gun shoot only fire straight up. To calculate this coordinates we take the players current X coordinate and add on half the players width to get the X coordinate at the center of the player and subtract 1 pixel to tweak the positioning a hair. We use `Std.int` to convert the `x + width / 2` statement to an integer which is required by the function. The reason it's not an integer to start with is that the X coordinate is not an integer but instead a decimal. To finish things off let's give our player a set number of lives they can lose before achieving a game over!

{% highlight haxe %}
public var lives:Int;
public var gun:FlxWeapon;

public function new()
{
	super(FlxG.width / 2 - 50, FlxG.height - 100, "assets/images/player_base.png");

	lives = 3;

	gun = new FlxWeapon("gun", this);
	gun.makeImageBullet(50, "assets/images/laser_green.png");
	gun.setFireRate(200);
	gun.setBulletSpeed(200);
	gun.setBulletOffset(width / 2 - 4, 0);
}
{% endhighlight %}

It's as simple as defining the lives as an integer and giving the player a starting amount of lives. I decided the classic 3 lives approach would be appropriate in this arcade style game.

## Boss

{% highlight %}
package;

import flixel.FlxG;
import flixel.FlxSprite;
import flixel.util.FlxTimer;
import flixel.util.FlxRandom;
import flixel.addons.weapon.FlxWeapon;

class Boss extends FlxSprite
{
	public function new(xPos:Int, yPos:Int, FinalY:Int)
	{

	}

	override public function update()
	{
		super.update();
	}
}
{% endhighlight %}

Here we have our boss class in it's most basic form. The boss is essentially programmed as an automated player. It's not smart but it gets the job done for our simple arcade shooter. The only real differences between the boss and player is how their health, movement, and shooting are handled. Since our boss follows a simple bit of artificial intelligence, or A.I. we have to tell it what to do and in what cases to do these things in. But before we can do that we need to arm, initialize, and set up our boss to be battle ready.

{% highlight %}
public var gun:FlxWeapon;
private var finalY:Int;

public function new(xPos:Int, yPos:Int, FinalY:Int)
{	
	super(xPos, yPos, "assets/images/enemy_ship.png");

	health = 5;

	finalY = FinalY;

	gun = new FlxWeapon("bossGun", this);
	gun.makeImageBullet(50, "assets/images/laser_red.png");
	gun.setFireRate(200);
	gun.setBulletSpeed(200);
	gun.setBulletOffset(width / 2 - 4, 0);
}
{% endhighlight %}

As you can see there are a few differences between the boss and the player. The immediate difference being they have a different positioning system. When the boss fight is initiated for aesthetics effects the boss is spawned higher on the screen that the player can see and it moves down to it's `finalY`. To make this happen we have to give the boss a position when it is spawned as well as specify what position to start it at, by not making these values in the boss class itself, we can actually spawn multiple bosses at multiple positions! The `gun` is the same as the player, the only difference being the graphic used and the name we give it. The name `bossGun` seemed appropriate.

{% highlight %}
override public function update():Void
{
	super.update();

	velocity.y = 0;

	if (y < finalY) 
	{
		velocity.y = 100;
		return;
	}
}
{% endhighlight %}

Here we implement that beginning movement. The boss moves from it's spawn location downward at a constant speed of 100 pixels per second until it reaches the specified `finalY` value. While the boss is moving to it's location we use a `return` statement to stop the AI we're yet to implement from running. Now that we have some basic AI, let's add some more!

{% highlight %}
override public function update():Void
{
	super.update();

	velocity.y = 0;

	if (y < finalY) 
	{
		velocity.y = 100;
		return;
	}

	if (x <= 0) 
		velocity.x += multiplier * 100;
	else if (x >= FlxG.width - 100) 
		velocity.x -= multiplier * 100;
}
{% endhighlight %}

When the boss is at it's final destination it can start moving left and right! To make this happen we use two simple checks. If the boss's x-coordinate is less than or equal to 0 we hit the left wall and need to start going the opposite direction! But what if we hit the right wall? In this case our `else if` statement comes into play. The right wall is offset 100 pixels, which is the width of the boss. We do this so instead of the top right pixel hitting the right wall, it will hit the offset.

{% highlight %}
public var gun:FlxWeapon;
public var multiplier:Int;

private var finalY:Int;

public function new(xPos:Int, yPos:Int, FinalY:Int)
{	
	super(xPos, yPos, "assets/images/enemy_ship.png");

	health = 5;

	finalY = FinalY;

	multiplier = 1;

	gun = new FlxWeapon("bossGun", this);
	gun.makeImageBullet(50, "assets/images/laser_red.png");
	gun.setFireRate(200);
	gun.setBulletSpeed(200);
	gun.setBulletOffset(width / 2 - 4, 0);
}
{% endhighlight %}

I also snuck a new variable in. `multiplier` will be used when we spawn multiple bosses. When a boss dies the idea is to increase `multiplier` by 1 so it speeds up the remaining bosses. For my last trick we will let the boss fire is lasers!

{% highlight %}
public var gun:FlxWeapon;
public var multiplier:Int;

private var finalY:Int;
private var shootTimer:FlxTimer;

public function new(xPos:Int, yPos:Int, FinalY:Int)
{	
	super(xPos, yPos, "assets/images/enemy_ship.png");

	health = 5;

	finalY = FinalY;

	multiplier = 1;

	gun = new FlxWeapon("bossGun", this);
	gun.makeImageBullet(50, "assets/images/laser_red.png");
	gun.setFireRate(200);
	gun.setBulletSpeed(200);
	gun.setBulletOffset(width / 2 - 4, 0);

	shootTimer.start(FlxRandom.floatRanged(1, 3 - (multiplier - 1)));
}
{% endhighlight %}

I decided to use a `FlxTimer` to make the boss's firing rate fit between a random range, as well as be affected by the multiplier. In this situation `FlxRandom` came to the rescue. By using `FlxRandom.floatRanged` I was able to get a random time between the range of `1` and `3 - (multiplier - 1)`. I derived this math from the logic that if we have 3 bosses, and the `multiplier` starts at one, that means when there is a single boss remaining the `multiplier` will be 3. So if we did `3 - (multiplier)` we'd be firing at a range of `1` to `0` seconds, which of course is illogical. So since I only plan to have a maximum of `3` bosses at once using a constant of `3` and `multiplier - 1` never going above 2, we can fire at a maximum rate of once per second. We use `shootTimer.start` so when the boss is done being initialized the timer starts counting down.

{% highlight %}
override public function update():Void
{
	super.update();

	velocity.y = 0;

	if (y < finalY) 
	{
		velocity.y = 100;
		return;
	}

	if (x <= 0) 
		velocity.x += multiplier * 100;
	else if (x >= FlxG.width - 100) 
		velocity.x -= multiplier * 100;

	if (shootTimer.finished)
	{
		gun.fireAtPosition(Std.int(x + width / 2) - 1, FlxG.height);
		shootTimer.reset(FlxRandom.floatRanged(1, 3 - (multiplier - 1)));
	}
}
{% endhighlight %}

Looking back I should've replaced the timer's range with a variable but this guide is on how I created the game originally so I'll leave it as is. `FlxTimer` has a parameter which would call a function when it reaches 0, but I did not know this until after I made my game so instead I checked every frame if the `shootTimer` was `finished` which meant that it was done counting down, and if so we'd fire the gun downward almost exactly like we did the players just with a simpler y-coordinate, and reset the timer to count down again from a new range! So we've officially completed our boss, soon it'll make for an epic boss battle!

## The Glue

*To be continued ...*