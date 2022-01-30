@extends('layout.conquer')

@section('tempat_titleatas')
<title>Edit Surat Keluar</title>
@endsection

@section('tempat_judul')
<p style="text-align: center;">UBAH DATA SURAT KELUAR</p>
@endsection

@section('tempat_konten')
<head>
<a href="{{route('surats.index')}}">
  Kembali</a>
<style>
/* #container #containerHeader{
    text-align: center;
    cursor:move;
}
#container #isiSurat {
    border: 1px solid black;
    height: 100px;
    margin: 0px auto 0;
    padding:10px;
   }
#container fieldset {
    margin: 2px auto 0px;
    width: 600px;
    height:50px;
    background-color: #f2f2f2;
    border:none;
}
#container button {
    width: 5ex;
    text-align: center;
    padding: 1px 3px;
    height:30px;
    width:30px;
    background-repeat: no-repeat;
    background-size: cover;
    border:none;
}
#container img{
      width:100%;
}
#container .bold{
background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAYAAAA4TnrqAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAJmSURBVHic7drPi05RHMfx18igGaaJzbAQShby22ZYKBb+CKyMJTsryo/IQigWUjbKnoWVpJSy8TOpIckCC0Xj1zTKGItLWcyZnmbuuY/z+L7rbO73PN/P93y65z73nHsIgiAIgiAIgiAIgiAIgiD43+lqSGc+1qB3Gr/9gfd4h5E6i/oX2YdRTNTQnuA4Fjc6gobYqLoz6jDq7/YVxzC7uaHk57D6jfq73cLCpgYzK3P+RZnz78ANzM2sg/xmNcEgLjQh1AlmwRA25RZpl1nXVa8trbYB7MbLRL4uHMlbcn7OmfzBfG2a+frxKJHzO/pmWO+UlDYNR1RTbjLmYHtO8dLMggd4nogtyylcolnwKnF9IKdoqWb1J65/yilaolkLsSERe5tTuESzjmJeInY3p3BJZvXgDPYn4k+ln2W10K5V+3pcarFvN5ZgCxZM0e/sTItqN6mX0rrbYw3MkpKmYYrP2IWfuYU6wayTeNaEUCeYdQhrmxDqBLP6cFW1NsxKu/4NX+Nmi327VcuYrdK7CmuwFxdnXFkbqXOLpgenE/km8KKGeqekpGk4ioM4n4ivxOqcBZRk1h+OYSwRG8wpXKJZH1W7pZOxPKdwiWaR/ozfnVO0VLNWJK5/ySlaolmbsSoRG84pXJpZ/biciI3jTk7xEszqUp2a2YP7WJfod1t1NKlYmtqimcC23IMp4c5qhSsyT0E6w6yHONCEUG6zPmTOfw87VRuAxZPr5N8YTmlgW6ZphvBNPSYN4wSWNjqC3zR1WrlXtZs5ndPK46rp/Ea1LgyCIAiCIAiCIAiCIAiCIAjaxi96FfJoiZEgRAAAAABJRU5ErkJggg==');
}
#container .italic{
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAYAAAA4TnrqAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAGDSURBVHic7do7SgRBFEbh0z5BwUhQTMxEMDAXQ1EXIS7AHehWBBMznQ0YizsQJhBfiIGB4Rjo4BiMRnZD11BV3eL5oNJbdS/VfyUNkiRJkiRJkvTfFU0f4Ns8sAZMRqr3AnSBfqR6rTABnACDBOsZ2MjXSnoHpBnUz3oApmIddixWoRFtJ66/DKzGKtb0sN4y7NHLsEcWW6T9DK9ozyMWxT5wC3wSb0g94BxYyNhHoxaBd8qH0WnwXK10RPXNSf0w/CkFcEP5oO5o/mFqlR2qb9Vhg+dqpQ7lg/oAlho8V+sY7AEM9poM9gAGewCDvSaDPYDBXpPBHsBgD2Cw12SwBzDYazLYAxjsAQz2mgz2AAZ7TQZ7AIM9gMHOMLTPgFeqb07o6gPXwF7GPpIrgEviDals7WbrJrEV0g5qAJxm66ZEzFdnJmKtKrMZ9qgUc1hd4ClivTIXietntcnwX84Un+AxMJ6vld9S/Og1DawDc5Hq9YF74DFSPUmSJEmSJEnSyL4AJ3NtCSNV9DYAAAAASUVORK5CYII=');
}
#container .underline{
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAYAAAA4TnrqAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAJhSURBVHic7drNahNRGMbxfw1WLBaiVtSioLiQrHSpWxERxAvQCxDcqjdRRBBX4qbriis3ikLxAhR3UhRcKC3FD6wgtmJ1XJwUnGTONCd5z5yZ8PzgUEjI+57zdD6SmQERERERERERkaaZAuaAd90x132taT0qMQ9kPWO+gT2i2wls0L+QTWBPg3rk7IhRFJgFdhW83gL2N6hHTqywJoZ8r249cmKFNZYUVgCFFUBhBVBYARRWAIUVQGEFUFgBFFYAhRVAYQVQWAEUVoBYYW2UvLfXqEfZNaufRj1yYoW1hrtqWeSIUQ9fnb/Ad6MeOTG3rI+e984Z9fDV+QD8MupRmUf0Xx/PcIuZHLH2JO6fUVR/YcTaXjEP8M88rx8Fro1Y+zr+3dDXt9b2UXz3JQO+ASeHrNvBHZOK6q5jdwKp3D2KF5UBb4FjgfWO426m+mretZh0KgfwbwUZ8Am4NGCty8DnklprwIzh3JO4hX+BW2MRuAK0ez7bBq4CLwaocSPuMqoxATxk+8VujVXgTffvoJ9ZINK9whSmgFcMvviQ8ZKGPgxSZhp4jG1QT+nfdcdGC7gN/GG0kDZxjxe1qp1+Gh3CjmP/j+fAqeqnnN5Z4AGwTHlAy8B94EyaaTp1OoOcwH2rn8U9e/UbWAGWgPcJ5yUiIuMuxtlwGjgNHIpQe1CrwGvgR8I5bOsC8JU4vwFDxxfgfNzlDm83YVcKqhgrFD/+PRTLa/Ad4KBhPQuHcfMyYRlWlHt1Buo6LxZJv+v1/ug2Y302bAN3gIu4Y1gq68AT4CY13rJERERERERERJx/gYhfcxk8X00AAAAASUVORK5CYII=');
}
#container .align-left{
    background-image : url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAAA1CAAAAAAsDUmHAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAACYktHRAAAqo0jMgAAAAlwSFlzAAAuIwAALiMBeKU/dgAAAAd0SU1FB+MIHAYHAD13ih8AAAIrSURBVEjHzZaxTxRBFMa/N7OH0FJqSwnChsTYnomKnJUKFOo1JrbGwpBYmwCV0X9AvMRK1IJ4OTtjYyCQ44xWtNpaa9x5z+IIt7vHbGYeV3DlJvfLm2++b76XCEb2S3DGWeJIRxBLJZboJxShAkvo94uuajBJH00ewZIj1J8bu4Y1LLPd/jLRh/VZLtnaPacTjGp7b5suyev1C5zp5CL8LGhPuASnFJ9xGXm9rNRXN0QVAZInV8Tm75FkfeWHSi+eTkueAHGaKv3Fpux7w6xDGTOcx8G3EeQx5m+WKlgiUZZgkJ9Ff9/sB9+jzN8dF/KwhOR2OzyPhrc+mmFYn8X2fXuMw8VPOu+W2HrmwmFUHhMcQjxnJMyAasEZIuAifHpZaTRbMXrduwnru0fCq5WDYL14bqHKq4LFxRh/SZW/yEU8OWQrMwR72jjmWE65DQxmHORRPRdT+S2UT10dKr1a6m2hB5vKfuTm60LXOtveTEj1GJJpLTeczefxG/BPe3u9hhTyOAWj7EeDqUI/Gtxa6Cj1yq7dgcnPJeZDq6vSi9P7pqA9SMYeqv011LXItKyhvRB0+s11QIjp7ZN7+ZjFUb19Ys8cZ9v0voejpmcr3kKhp2sU3h2yuu7tWmc/r8WckTeu1523H3dgI/JY46918ep1HiYJP6PBBa/2Fksv9yL6MZtf9vYjyXjneS+8H2cfT3i1B8nksxiLS2U/ShaxRkvlXjjaPOJMsf4DQ22vjD/V/uUAAAAASUVORK5CYII=');
    width:40px;
}

#container .align-right{
    background-image:url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAAA1CAAAAAAsDUmHAAAAIGNIUk0AAHomAACAhAAA+gAAAIDoAAB1MAAA6mAAADqYAAAXcJy6UTwAAAACYktHRAAAqo0jMgAAAAlwSFlzAAAuIwAALiMBeKU/dgAAAAd0SU1FB+MIHAYOC3tn6N4AAAIsSURBVEjHzZexaxRBFMa/NzMXkzaltimjcQmI7QlqzFmpSQr1GsFWLCRgLSSpRP8B44GViRYhx9mJjRgi54lWabW1VtyZZ5GAM7uZZeYlRbbchY8337zf+94axrE9Bidciy3JFFhTRYvlFTJToMX069lQVBgXDyYPxMyB1O9rO8pJtNRW/8PEvti+ljUbO6dkhlFr93XXGt+vn3ClzC7Cj8B7wgVYofkOF+H7pbm9vMYiBIgfXWLt3yPx6tJ3kV9uuqj0BMgVhbC/nKr2vXJOJqVUncf/746VbbY5EjUeQ8Cy2sOB4lr059Xn5Dvl2dvjAY/BR+Kb/XQ2ldvYVj6PQcn6TX/MpV+EGWwuOB2pC3tZbBrsgSNnJJwFtZJ5IuAcYn5p7nR7OX7duQ4du0fCi6UvyX6583NNvcqYn8/pL27qL7IZ44d0I0PQR+TRCreBel3MsloAOKrOQn43lEkVlytzguneujAfXfdlwLbV/XVDomFIqrfYsR6PjK/AX9kZDUYdn0fCFJQwHxWmAh4VbswNhH6VV25B+XWxetsbivxyxV0VzlXisfvi/qplLUqpVj2H6Oib6+EKORl+WG77UlkZXt8nvIfV6Fu61PRMwyxkerxC6dnBy6vRrLX6/UrOGd3a1baN5uMn6Aw2W+5jm6N+nYYy6WdUOBP1XmPh+W5GPpazi9F8JB4fPB2l5+PMw4mo9yCefJLT7tyYj1xmrNTcuBdK2Typ/7X/ACjdr4z8YnCHAAAAAElFTkSuQmCC');
    width:40px;
}
#container .align-center{
    width: 38px;
    background-size: contain;
    background-image:url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABQAAAAOCAYAAAAvxDzwAAAABGdBTUEAALGPC/xhBQAAADRJREFUOBFjYGBg2ArE/6mEtzIBDaImADlsCAJSwhSkFgVQGoYjIMwIpdfRdAhJUYMrHQIAWPdBdW2q70gAAAAASUVORK5CYII=');
}

#container .redo-apply{
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAYAAAA4TnrqAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAKJSURBVHic7du7axRRGIbxn260MELQIoIIFjYBa01lI0btFVEQRBtbSeEFUmhnbeEfoOK1EkQQKxsLUbH00gQLxesuRBANMRZrIJHd2T3jzsyOfA98zdnZc9555sxyZnaGIAiCIAjqw2HcwTXsrjjLUHMBi8vqF85UmmhIWY95K2Ut1dkKcw0lEzqLCmEdWINPQljfHMCCENY3x/UWNlNZuiEkhCUSwhIJYYmEsERCWCIhLJFShK361w56MIot2IS1BY91DEd7bHMOFwvOkcQmnMZjvY92FTVd3K73zyjOY071QrLqJ7YXo6A/tuKF6kX0W6fy7ORIni/9xQQeYXwAfZVFq4pBN+C16mdKSr37k7t0bucIW2W1MFmIiR5Mat8LzzqC09iGRsFZRrT/zOglamfBObpyLyPYA4yVlKMfUU0VihrDjy7BnmNdSTmGXhQc6hBqqXaVlKFfUTtKytOVGZ3DvSlp/NqIgss6B7xVwtgNXO8yfqE/5nkXpd3WKc28QfpkBDdwMGObJvbi6aAHXz3g/hYH3N9yGrgiW1QL+xUgisHLKooGruJIxjYt7MOTokIM4tqwDC7JFtXEFJ4VGaIOM2scJzM+L0UU9ZhZ47pfLjWxR3shXDh1mFmv8KFD+1cliqIesuZxAt+Xtc0qWRT1OA3hvvbdiynt29YP8a3sEHWRBe+111mVUYfTcGgIWQmErARCVgIhK4GQlUDISiBkJRCyEghZCYSsBEJWAiErgZCVQMhKIGQlELISCFkJhKwEQlYCISuBkJVAXlkLXdqLfOSocvLKetmlfTZnf/81m/HRykcT32JjlaGKJu/D/HO4qf2+4hfc1X5B8vOAcgVBEARBMJT8BsNk0YqzYcGdAAAAAElFTkSuQmCC');
}
#container .undo-apply{
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAYAAAA4TnrqAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAALFSURBVHic7ZzPi05RGMc/M0aSJDZMUXaSlB3T+DGkWCgW2Cn+AYVsSBo/xm78LpoihcmUlIXyIxbWYolSQ7IgeY0fM2Te1+JsmO499zz3fZ97jvF86mxuvef53k/nvfe8z729YBiGYRhGHLYCQ8A1YEPkLMnSBpwDGhPGrpihUiRPVAN4FzFXcrQBZ8gW1QDqwPRo6RLjFPmiGsDTeNHSoh+/qFGgK1q6hOjDL+oHsClauoQ4jokK4hgmKoijmKggjmCigujFRAVxGBMVxH7+E1EdTX7+AG6L4OMsMAasb7JWFp+AYeCjwtwtZS/+FVXleA1cBjYC7ZonXYYlwE/iS8oaL4EduB/vSbCH+FKKxmNgYStPuuyS/dzKEEqsxHUz1sYOMhvXsIu9ekLGGO5aFpXlQI34MkLGV2CZjoZwVuC+kr6gQzS/RcliKrAA2A7cAH4V5HgBzFDIIaKLYmGDwBTlHIuBRwU5+pQzBNENjOAPehV9YR3ARU+G78Bc5QxBdANf8Au7gv6msR245cnQq1w/mFUUC7uEvrBZwIec+q+Ua4tYjbv7+IQNoL/D3uepv0i5tog1FAu7gK6wecB4Tu3knoD3AN/wCzuPrrAnOXVPKNYsTcg17DR6wm7m1BxQqtc06yheYQeVaudtIwbLTFZF7+chsBn35DmPQ7g7WKupt3KyqhplD/ALmwbMryhLaarsKt4HtuC6ABMZIbH9TxZVt2Dv4YTV/jhWB3aTLTEpNLoBRdwFlgLbgJnAbeBZhBxiYsgCeAucjFS7NMk9CUkZkyXAZAkwWQJMlgCTJcBkCTBZAkyWAJMlwGQJMFkCTJYAkyXAZAkwWQJMlgCTJcBkCTBZAkyWAJMlYLLLGs853igz2WSX9Tzn+HCVIf4V5gBv+Pt1o/dAZ5nJtF+1js0ocB0nqQbcAXZi/31jGIZhGCX5DTQy/pTFeqp6AAAAAElFTkSuQmCC');
}
#container .unorderedlist{
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAYAAAA4TnrqAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAI0SURBVHic7dq7axRBGADw30UloEaICAbBQoVgwEcvKWx8gEh6sUqhf4jYaauFVtFGwUK00MrOR2ER8ZFCFBUj+ERFET2NxSgiZHbv9kJul3w/+JrZb4eZ79i527khhBBCCCGEEEIIIYQQlrpWBzkbMIIZfO0gfznGsL6HcS22H3iAt1U7aOEUfmIOH3Co5J5xzP7Jb2KcxbIu6wQOz9PZN2zJ5A/ieQ0m3GsczRVkoKBYE5mC7M/kj2FjQX9NsS93oahYnzPtnzLtnaxnTfClyk27/Fuv/sYrDGfyW7ipP4/OQsaeKsUiPYrT+Igb2FmSP4JL0qfT70l3E7/wWFqnQwghhBBCqK+y/awhHMEo7mAK7ZJ7DmA31vQ6uEU0J/2Cn8LrKh2sxVP/vxZcUVzgYxb/VWUhY1ba7Oza8UyHuRfNdfhegwn3GidyBSnaotmRad+ead+MFQX9NcXW3IWiYk1n2u9l2p9Ie9lNN1PlpvnWrMuW8JrVybfhpPSI3cYFae+nyEFpa7Zpj+RLnMabfg8khBBCCCGEyiZwF+9xDdtK8kdwEe/0/9Wlm2jjvh7+ka5y1uFWDSbea+ytUqzzmc4mM/mjNZjoQsS5XEGKtmiGMu2rM+0rC/pqklW5C0XFujpPWxvXM/mP8KKLQdVVbn6FBnBSKtCcdKa0bAEcl7Y6+v0oVY0zCs6UdnJaeRib8FA6U1pmUDrH1aR/d9rSRuezfg8khBBCCCGEEEIIIYQQ6u03kq1rwGv96WIAAAAASUVORK5CYII=');
}
#container .orderedlist{
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEsAAABLCAYAAAA4TnrqAAAABHNCSVQICAgIfAhkiAAAAAlwSFlzAAAuIwAALiMBeKU/dgAAABl0RVh0U29mdHdhcmUAd3d3Lmlua3NjYXBlLm9yZ5vuPBoAAAJDSURBVHic7dq9TxRBGMfx7x2KQfSQzhCICRgSk9OKBgobwY6KhARLC/4CaioKqAQLGwtfao0k0BITNbGSoFEIEBrsjAQTCETepJi7gMfOvrl7Oye/TzLNZGb3mefYJfPsgIiIiIiIiIiIiMh5lws57gJQBLaAtZBzmoHbQH2MuLLyE/gG7Me9QBFYBf6U2nvgus/4HPAYODo1p5baD6A3Rp7IAV89LvjaZ84DBxacRMKuRE3WTcvFdjGPppfnDiw2iXa3cmH5gGTtlCZWOsA8ZrY5/4NY65jmbNYf+YzvpnbfV+X2GaiLniooAE+BX5hneRz7I1g2ACwDhw4sPErbBWaAtqhJEhERERGpirD1rKiuAQ+BdmAeeInZT/q5B9wvzc3KNvABeFOtGzYDK/y9jZjDf681QjbbG1ub/McchDZqCWDQMr6Bk+qGK+0QuFEZaFCJJo6ipf+Opb8NkzCX5IFOr86kLVr6lyz93zG7fZccYaomqWvCJOb0n/U7/D9c1MQ7K63/hgVgGFOW/gS8APYC5vQB/cCllGIK4wB4C7zKMAYREREREfcVgGfAJrAOjBF8rmsAWMDsDJLa5mxijis4/UV6hrOBT/iM7yHd8xRfCD6ikIkWvAPewL53fWKZk2TrqrxpGiWaqBot/Vex/7qXU4ql2veIzHa6cNZnzpDH+CRbrJN/1XILU2wrB/uR4HOrU6Tz3rKeKU2rnhVHHlOS/s3JB48grUAHcDGhGLYxB9lcq9yKiIiIiIiIiIiIOOIYaxc11Cpvh4UAAAAASUVORK5CYII=');
}
#container .strikethrough{
    background-image: url('data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAB4AAAAeCAQAAACROWYpAAAAAmJLR0QA/4ePzL8AAABFSURBVEjHY2AY2eAww38i4GHsmv8TCXFqxmYYPjVIzj5MUPNhXM7G5Q2ywKhm2mo+TG7ipFjzYAGjiYTs8uwwHTUPZwAAW5aYHd3noZcAAAAASUVORK5CYII=');
}
#container .color-apply{
    width: 20px;
}
#container #input-font{
    width: 100px;
    height: 25px;
}
[contentEditable=true]:empty:not(:focus):before{
    content:attr(data-text);
    color:#888;
}
#container .loader {
    border: 6px solid #f3f3f3; 
    border-top: 6px solid #3498db; 
    border-radius: 50%;
    width: 20px;
    height: 20px;
    animation: spin 2s linear infinite;
    margin: 0 auto;
    line-height: 20px;
}

 @keyframes spin {
0% { transform: rotate(0deg); }
100% { transform: rotate(360deg); }
} */ 
  </style>
</head>
<script>
var count = 0;
</script>

<body onload="mulai()">
  <form method="POST" action="{{url('surats/'.$s[0]->nomor_surat)}}" formtarget="_blank" target="_blank" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <br />
    <div class="form-group row">
      <label for="jenis" class="bold col-sm-2 col-form-label">Jenis surat keluar:</label>
      <div class="col-sm-4">
        <select name="jenis" id="jenis" class="form-control">
          <option value="1">Surat Keluar Dekan</option>
          <option value="2">Surat Keluar Wakil Dekan</option>
          <option value="3">Surat Keluar Kaprodi Magister Bioteknologi</option>
        </select>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label" for="noSurat">No Surat Keluar:</label>
      <div class="col-sm-4">
        <input type="input" id="noSurat" class="form-control" name="noSurat" value='{{str_replace("-","/",$s[0]->nomor_surat)}}' style="width:300px;" required readonly/>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label" for="Tanggal">Tanggal Kirim:</label>
      <div class="col-sm-2">  
        <input type="date" class="form-control" name="Tanggal" id="Tanggal" style="width: 200px;" value="{{ date('Y-m-d', strtotime($s[0]->tanggal_kirim)) }}" required/>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Perihal:</label>
      <div class="col-sm-4">
        <input type="input" class="form-control" name="perihal" value="{{$s[0]->perihal}}" required>
      </div>
    </div>
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Lampiran:</label>
      <div class="col-sm-2">
        <input type="input" class="form-control" name="lampiran" value ="{{$la}}" required>
      </div> 
    </div>  
    <br/>
    <div class="form-group row">
      <label class="required bold col-sm-2 col-form-label">Kepada:</label>
      <div class="col-sm-3">
        <input type="input" class="form-control" name="kepada" value="{{$kepada}}" required>
      </div> 
    </div>
    <br/>
    <div id="container">
      <label class="required bold"> Isi Surat </label>
      <textarea name="isiSurat" id="isiSurat" rows="8" class="form-control"  required>{{$isiSurat}}</textarea>  
    </div>
    <br/> 
    <input type="checkbox" name="tcheck[]" value="pTabel" id="tcheck" onclick="tOn()" @if ($counttable > 1 ) checked @endif>
      <label>Gunakan Tabel?</label>
      <br/>
      <div id="hiddenTable" style="display: none;">
        <label class="required">Jumlah Baris</label>
        <input type="input" class="form-control" name="noRow" id="noRow" min="1">
        <br />
        <label class="required">Jumlah Kolom</label>
        <input type="input" class="form-control" name="noCol" id="noCol" min="1" max="6">
        <br/>
        <div>
          <button type="button" class="btn btn-primary" name="tambahTable" onclick="addTable()">Buat Tabel baru</button>
        </div>
        <br/>
        <table style='border: 1px solid black; border-collapse: collapse;  width: 100%;' id="tbl">
        </table>
      </div>
      <br/>
      <label class="required bold"> Penutup Surat </label>
      <textarea name="penutup" id="penutup" rows="8" class="form-control" required>{{$penutup}}</textarea>  
    <br/><br/>
    <div id="tempat_upload">
      <input id="hiddenJenis" type="hidden" name="jenis">
    <input type="hidden" name="tglbuat" id="tglbuat" value='{{$s[0]->created_at}}'/>
      <label>Upload Lampiran</label>  
      @isset($arrayNama) 
      <script>
          count = <?php echo json_encode(count($arrayNama)); ?>;
      </script>
        @for($i=1;$i<=count($arrayNama); $i++)
        <div>
          <input type="file" name="uploadfile{{$i}}" id="uploadfile{{$i}}" onchange="changeLampText(this.id)" style="display: none;" accept=".pdf,.jpg">
          <label style="color: blue; text-decoration: underline;" for="uploadfile{{$i}}" value="{{$arrayNama[$i-1]}}.{{$arrayExtension[$i-1]}}">{{$i}}. {{$arrayNama[$i-1]}} (Klik disini untuk mengubah)</label>
          <input type="hidden" name="lampuploadfile{{$i}}" id="lampuploadfile{{$i}}" value='{{$arrayNama[$i-1]}}.{{$arrayExtension[$i-1]}}'/>
        </div>
        @endfor
      @endisset
    </div>
    <h5>Format file PDF/JPG</h5>
    <div>
    <button type="button" class="btn btn-primary" name="tambahLampiran" onclick="addInputFile()">Tambah Lampiran</button>
    </div>
    <br/>
    <input type="submit" class="btn btn-primary" value="Simpan Surat" name="submit" onclick="CekCount()">
  </form>
</body>

<script>
var trNum = 0;
var tdNum = 0;

function mulai() {
  var sel = document.getElementById('jenis');
  sel.selectedIndex = parseInt(<?php echo json_encode($js)-1?>);
  $('#hiddenJenis').val(sel.selectedIndex);

  var counttable = <?php echo json_encode($counttable) ?>;
  var countrow = parseInt(<?php echo json_encode($countrow) ?>);

  if (counttable > 1) {
    var x = document.getElementById("hiddenTable");
    x.style.display = "block";
    
    var currentData = 1;

    var arraytable = <?php echo json_encode($arraytable) ?>;
    var countcol = parseInt(counttable/2)/(countrow - 1);
    document.getElementById("noRow").value = countrow - 1;
    document.getElementById("noCol").value = countcol;
    $htmlTbl = "";

    for (i=1;i<countrow;i++) {
      $htmlTbl += `<tr id="tr${i}" style='border: 1px solid black; border-collapse: collapse;'>`;
      for (j=1;j<=countcol;j++){
        $htmlTbl += `<td style="width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable>${arraytable[currentData]}</div></td>`;
        currentData += 2;
      }
      $htmlTbl += '</tr>';
  } 

    $('#tbl').append($htmlTbl);

    trNum = countrow-1;
    tdNum = countcol;

    $html = `<input type="hidden" name="jumrow" id="jumrow" value='${trNum}'/>
            <input type="hidden" name="jumcol" id="jumcol" value='${tdNum}'/>`;
    $('#tempat_upload').append($html);
    }
}

  function addInputFile() {
    count+=1; 
    $html = `<input type="file" name="uploadfile${count}" class="form-control" accept=".pdf,.jpg">`;
    $("#tempat_upload").append($html);
}

function CekCount()
{
    if ($('#count').length) {
      var x = document.getElementById("count");
      x.remove();
    }

    $html=`<input type="hidden" name="count" id="count" value='${count}'/>`; 
    for (i=1;i<=trNum;i++) {
      for (j=1;j<=tdNum;j++){
        var y = $(`#tr${i}td${j}`).html();
        $html += `<input type="hidden" name="instr${i}td${j}" id="instr${i}td${j}" value='${y}'/>`;
      }
  } 
  $('#tempat_upload').append($html);
}

function tOn() {
    var x = document.getElementById("hiddenTable");
    if (x.style.display === "none") {
      x.style.display = "block";
    } else {
      x.style.display = "none";
    }
  }

function changeLampText(id) {

  var labelId = "label[for="+id+"]";

  if ($(labelId).length) {
    var x = document.getElementById(id);
    x.style.display = "block";

    if ($(`#lamp${id}`).length) {
      $(`#lamp${id}`).remove();
    }
    var value = $(labelId).attr("value");
    $html = `<input type="hidden" name="lamp${id}" id="lamp${id}" value='${value}'/>`;

    $('#tempat_upload').append($html);
    $(labelId).remove();
  }
  
}

function addTable() {

  if($('#tr1').length) {
    var k;
    var l;
    for (k = 1; k <= trNum; k++) {
      for (l=1; l <= tdNum; l++) {
        var obj = document.getElementById(`tr${k}td${l}`);
        obj.remove();   
      }
      var myobj = document.getElementById(`tr${k}`);
      myobj.remove(); 
    }   
    var r = document.getElementById(`jumrow`);
    r.remove();
    var c = document.getElementById(`jumcol`);
    c.remove();
  }

  $row = document.getElementById("noRow").value;
  $col = document.getElementById("noCol").value;
  $htmlTbl = "";

  var i;
  var j;      

  for (i=1;i<=$row;i++) {
    $htmlTbl += `<tr id="tr${i}" style='border: 1px solid black; border-collapse: collapse;'>`;
    for (j=1;j<=$col;j++){
      if (i == 1) {
        $htmlTbl += `<td style="width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable><center><b>Judul Kolom</b></center></div></td>`;
      } else {
        $htmlTbl += `<td style="width: 200px; border: 1px solid black; border-collapse: collapse;"><div id="tr${i}td${j}" contenteditable></div></td>`;
      }
    }
    $htmlTbl += '</tr>';
  } 
  $('#tbl').append($htmlTbl);

  trNum = $row;
  tdNum = $col;

  $html = `<input type="hidden" name="jumrow" id="jumrow" value='${trNum}'/>
           <input type="hidden" name="jumcol" id="jumcol" value='${tdNum}'/>`;
  $('#tempat_upload').append($html);

}

function chooseColor(){
      var mycolor = document.getElementById("myColor").value;
      document.execCommand('foreColor', false, mycolor);
    }

    function changeFont(){
      var myFont = document.getElementById("input-font").value;
      document.execCommand('fontName', false, myFont);
    }

    function changeSize(){
      var mysize = document.getElementById("fontSize").value;
      document.execCommand('fontSize', false, mysize);
    }

    function checkDiv(){
      var editorText = document.getElementById("editor1").innerHTML;
      if(editorText === ''){
        document.getElementById("editor1").style.border = '5px solid red';
      }
    }

    function removeBorder(){
      document.getElementById("editor1").style.border = '1px solid transparent';
    }
</script>
@endsection