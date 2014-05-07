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

*To be continued...*