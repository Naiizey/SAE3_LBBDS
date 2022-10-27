<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>404 Page Not Found</title>

    <style>
        div.logo {
            height: 200px;
            width: 155px;
            display: inline-block;
            opacity: 0.08;
            position: absolute;
            top: 2rem;
            left: 50%;
            margin-left: -73px;
        }
        body {
            height: 100%;
            background: #fafafa;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #777;
            font-weight: 300;
        }
        h1 {
            font-weight: lighter;
            letter-spacing: normal;
            font-size: 3rem;
            margin-top: 0;
            margin-bottom: 0;
            color: #222;
        }
        .wrap {
            max-width: 1024px;
            margin: 5rem auto;
            padding: 2rem;
            background: #fff;
            text-align: center;
            border: 1px solid #efefef;
            border-radius: 0.5rem;
            position: relative;
        }
        pre {
            white-space: normal;
            margin-top: 1.5rem;
        }
        code {
            background: #fafafa;
            border: 1px solid #efefef;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            display: block;
        }
        p {
            margin-top: 1.5rem;
        }
        .footer {
            margin-top: 2rem;
            border-top: 1px solid #efefef;
            padding: 1em 2em 0 2em;
            font-size: 85%;
            color: #999;
        }
        a:active,
        a:link,
        a:visited {
            color: #dd4814;
        }
    </style>
</head>
<body>
    <div class="wrap">
        <h1>404 - File Not Found /!\ Page Temporaire</h1>
        <p>
            <?php if (ENVIRONMENT !== 'production') : ?>
                <?= nl2br(esc($message)) ?>
            <?php else : ?>
                Sorry! Cannot seem to find the page you were looking for.
            <?php endif ?>
        </p>
    </div>
    <!-- include john travolta -->
    <div class="tenor-gif-embed" data-postid="10251428" data-share-method="host" data-aspect-ratio="1.03734" data-width="100%">
        <a href="https://tenor.com/view/pulp-fiction-john-travolta-lost-where-wtf-gif-10251428">Pulp Fiction John Travolta GIF</a>from <a href="https://tenor.com/search/pulp+fiction-gifs">Pulp Fiction GIFs</a>
    </div> <script type="text/javascript" async src="https://tenor.com/embed.js"></script>
    <!-- reduce the size of the gif -->
    <style>
        .tenor-gif-embed {
            width: 25%;
            height: 25%;
            max-width: 25%;
            max-height: 25%;
        }

        /* center */
        .tenor-gif-embed {
            margin: 0 auto;
        }
    </style>
</body>
</html>
