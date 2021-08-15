(function(a) {
    a.widget("ui.rcarousel", {
        _create: function() {
			
			 console.log("rcarousel");
			
            var d, e = a(this.element),
                b = this,
                c = this.options;
            this._checkOptionsValidity(this.options);
            this._createDataObject();
            d = e.data("data");
            
			/* e.addClass("ui-carousel").children().wrapAll("<div class='wrapper'></div>"); */
			
            this._saveElements();
            this._generatePages();
            this._loadElements();
            this._setCarouselWidth();
            this._setCarouselHeight();
            a(c.navigation.next).click(function(f) {
                b.next();
                f.preventDefault()
            });
            a(c.navigation.prev).click(function(f) {
                b.prev();
                f.preventDefault()
            });
            d.navigation.next = a(c.navigation.next);
            d.navigation.prev = a(c.navigation.prev);
            e.hover(function() {
                if (c.auto.enabled) {
                    clearInterval(d.interval);
                    d.hoveredOver = true
                }
            }, function() {
                if (c.auto.enabled) {
                    d.hoveredOver = false;
                    b._autoMode(c.auto.direction)
                }
            });
            this._setStep();
            if (c.auto.enabled) {
                this._autoMode(c.auto.direction)
            }
            this._trigger("start")
        },
        _addElement: function(f, e) {
            var d = a(this.element),
                c = d.find("div.wrapper"),
                b = this.options;
            f.width(b.width).height(b.height);
            if (b.orientation === "horizontal") {
                a(f).css("marginRight", b.margin)
            } else {
                a(f).css({
                    marginBottom: b.margin,
                    "float": "none"
                })
            }
            if (e === "prev") {
                c.prepend(f.clone(true, true))
            } else {
                c.append(f.clone(true, true))
            }
        },
        append: function(d) {
            var c = a(this.element),
                b = c.data("data");
            d.each(function(e, f) {
                b.paths.push(a(f))
            });
            b.oldPage = b.pages[b.oldPageIndex].slice(0);
            b.appended = true;
            this._generatePages()
        },
        _autoMode: function(d) {
            var b = this.options,
                c = a(this.element).data("data");
            if (d === "next") {
                c.interval = setTimeout(a.proxy(this.next, this), b.auto.interval)
            } else {
                c.interval = setTimeout(a.proxy(this.prev, this), b.auto.interval)
            }
        },
        _checkOptionsValidity: function(c) {
            var d, b = this,
                e = "";
            a.each(c, function(f, g) {
                switch (f) {
                    case "visible":
                        if (!g || typeof g !== "number" || g <= 0 || (Math.ceil(g) - g > 0)) {
                            throw new Error("visible should be defined as a positive integer")
                        }
                        break;
                    case "step":
                        if (!g || typeof g !== "number" || g <= 0 || (Math.ceil(g) - g > 0)) {
                            throw new Error("step should be defined as a positive integer")
                        } else {
                            if (g > b.options.visible) {
                                for (d = 1; d <= Math.floor(c.visible); d++) {
                                    e += (d < Math.floor(g)) ? d + ", " : d
                                }
                                throw new Error("Only following step values are correct: " + e)
                            }
                        }
                        break;
                    case "width":
                        if (!g || typeof g !== "number" || g <= 0 || Math.ceil(g) - g > 0) {
                            throw new Error("width should be defined as a positive integer")
                        }
                        break;
                    case "height":
                        if (!g || typeof g !== "number" || g <= 0 || Math.ceil(g) - g > 0) {
                            throw new Error("height should be defined as a positive integer")
                        }
                        break;
                    case "speed":
                        if (!g && g !== 0) {
                            throw new Error("speed should be defined as a number or a string")
                        }
                        if (typeof g === "number" && g < 0) {
                            throw new Error("speed should be a positive number")
                        } else {
                            if (typeof g === "string" && !(g === "slow" || g === "normal" || g === "fast")) {
                                throw new Error('Only "slow", "normal" and "fast" values are valid')
                            }
                        }
                        break;
                    case "navigation":
                        if (!g || a.isPlainObject(g) === false) {
                            throw new Error("navigation should be defined as an object with at least one of the properties: 'prev' or 'next' in it")
                        }
                        if (g.prev && typeof g.prev !== "string") {
                            throw new Error("navigation.prev should be defined as a string and point to '.class' or '#id' of an element")
                        }
                        if (g.next && typeof g.next !== "string") {
                            throw new Error(" navigation.next should be defined as a string and point to '.class' or '#id' of an element")
                        }
                        break;
                    case "auto":
                        if (typeof g.direction !== "string") {
                            throw new Error("direction should be defined as a string")
                        }
                        if (!(g.direction === "next" || g.direction === "prev")) {
                            throw new Error("direction: only 'right' and 'left' values are valid")
                        }
                        if (isNaN(g.interval) || typeof g.interval !== "number" || g.interval < 0 || Math.ceil(g.interval) - g.interval > 0) {
                            throw new Error("interval should be a positive number")
                        }
                        break;
                    case "margin":
                        if (isNaN(g) || typeof g !== "number" || g < 0 || Math.ceil(g) - g > 0) {
                            throw new Error("margin should be a positive number")
                        }
                        break
                }
            })
        },
        _createDataObject: function() {
            var b = a(this.element);
            b.data("data", {
                paths: [],
                pathsLen: 0,
                pages: [],
                lastPage: [],
                oldPageIndex: 0,
                pageIndex: 0,
                navigation: {},
                animated: false,
                appended: false,
                hoveredOver: false
            })
        },
        _generatePages: function() {
            var i = this,
                j = this.options,
                c = a(this.element).data("data"),
                b = j.visible,
                h = c.paths.length;

            function f() {
                c.pages = [];
                c.lastPage = [];
                c.pages[0] = [];
                for (var k = h - 1; k >= h - b; k--) {
                    c.lastPage.unshift(c.paths[k])
                }
                for (var k = 0; k < b; k++) {
                    c.pages[0][c.pages[0].length] = c.paths[k]
                }
            }

            function d(m) {
                var k = false;
                for (var l = 0; l < c.lastPage.length; l++) {
                    if (c.lastPage[l].get(0) === m[l].get(0)) {
                        k = true
                    } else {
                        k = false;
                        break
                    }
                }
                return k
            }

            function e(o, k, m) {
                var n = m || c.pages.length;
                if (!m) {
                    c.pages[n] = []
                }
                for (var l = o; l < k; l++) {
                    c.pages[n].push(c.paths[l])
                }
                return n
            }

            function g() {
                var p = true,
                    o = false,
                    m = j.step,
                    k, q, n, l;
                while (!d(c.pages[c.pages.length - 1]) || p) {
                    p = false;
                    k = m + b;
                    if (k > h) {
                        k = h
                    }
                    if (k - m < b) {
                        o = true
                    } else {
                        o = false
                    }
                    if (o) {
                        n = m - (b - (k - m));
                        l = n + (b - (k - m));
                        q = e(n, l);
                        e(m, k, q)
                    } else {
                        e(m, k);
                        m += j.step
                    }
                }
            }
            f();
            g()
        },
        getCurrentPage: function() {
            var b = a(this.element).data("data");
            return b.pageIndex + 1
        },
        getTotalPages: function() {
            var b = a(this.element).data("data");
            return b.pages.length
        },
        goToPage: function(d) {
            var b, c = a(this.element).data("data");
            if (!c.animated && d !== c.pageIndex) {
                c.animated = true;
                if (d > c.pages.length - 1) {
                    d = c.pages.length - 1
                } else {
                    if (d < 0) {
                        d = 0
                    }
                }
                c.pageIndex = d;
                b = d - c.oldPageIndex;
                if (b >= 0) {
                    this._goToNextPage(b)
                } else {
                    this._goToPrevPage(b)
                }
                c.oldPageIndex = d
            }
        },
        _loadElements: function(b, h) {
            var k = this.options,
                e = a(this.element).data("data"),
                f = h || "next",
                j = b || e.pages[k.startAtPage],
                c = 0,
                g = j.length;
            if (f === "next") {
                for (var d = c; d < g; d++) {
                    this._addElement(j[d], f)
                }
            } else {
                for (var d = g - 1; d >= c; d--) {
                    this._addElement(j[d], f)
                }
            }
        },
        _goToPrevPage: function(k) {
            var c, j, f, l, g, m, n, p, b, h = a(this.element),
                o = this,
                q = this.options,
                e = a(this.element).data("data");
            if (e.appended) {
                j = e.oldPage
            } else {
                j = e.pages[e.oldPageIndex]
            }
            l = e.oldPageIndex + k;
            c = e.pages[l].slice(0);
            a(c).each(function(r, s) {
                if (s.get(0) === a(j[r]).get(0)) {
                    b = true
                } else {
                    b = false
                }
            });
            if (e.appended && b) {
                if (e.pageIndex === 0) {
                    l = e.pageIndex = e.pages.length - 1
                } else {
                    l = --e.pageIndex
                }
                c = e.pages[l].slice(0)
            }
            m = c[c.length - 1].get(0);
            for (var d = j.length - 1; d >= 0; d--) {
                if (m === a(j[d]).get(0)) {
                    n = false;
                    p = d;
                    break
                } else {
                    n = true
                }
            }
            if (!n) {
                while (p >= 0) {
                    if (c[c.length - 1].get(0) === j[p].get(0)) {
                        c.pop()
                    }--p
                }
            }
            o._loadElements(c, "prev");
            f = q.width * c.length + (q.margin * c.length);
            if (q.orientation === "horizontal") {
                g = {
                    scrollLeft: 0
                };
                h.scrollLeft(f)
            } else {
                g = {
                    scrollTop: 0
                };
                h.scrollTop(f)
            }
            h.animate(g, q.speed, function() {
                o._removeOldElements("last", c.length);
                e.animated = false;
                if (!e.hoveredOver && q.auto.enabled) {
                    clearInterval(e.interval);
                    o._autoMode(q.auto.direction)
                }
                o._trigger("pageLoaded", null, {
                    page: l
                })
            });
            e.appended = false
        },
        _goToNextPage: function(l) {
            var c, k, f, m, g, j, n, p, b, h = a(this.element),
                q = this.options,
                e = h.data("data"),
                o = this;
            if (e.appended) {
                k = e.oldPage
            } else {
                k = e.pages[e.oldPageIndex]
            }
            m = e.oldPageIndex + l;
            c = e.pages[m].slice(0);
            a(c).each(function(r, s) {
                if (s.get(0) === a(k[r]).get(0)) {
                    b = true
                } else {
                    b = false
                }
            });
            if (e.appended && b) {
                c = e.pages[++e.pageIndex].slice(0)
            }
            j = c[0].get(0);
            for (var d = 0; d < c.length; d++) {
                if (j === a(k[d]).get(0)) {
                    n = false;
                    p = d;
                    break
                } else {
                    n = true
                }
            }
            if (!n) {
                while (p < k.length) {
                    if (c[0].get(0) === k[p].get(0)) {
                        c.shift()
                    }++p
                }
            }
            this._loadElements(c, "next");
            f = q.width * c.length + (q.margin * c.length);
            if (q.orientation === "horizontal") {
                g = {
                    scrollLeft: "+=" + f
                }
            } else {
                g = {
                    scrollTop: "+=" + f
                }
            }
            h.animate(g, q.speed, function() {
                o._removeOldElements("first", c.length);
                if (q.orientation === "horizontal") {
                    h.scrollLeft(0)
                } else {
                    h.scrollTop(0)
                }
                e.animated = false;
                if (!e.hoveredOver && q.auto.enabled) {
                    clearInterval(e.interval);
                    o._autoMode(q.auto.direction)
                }
                o._trigger("pageLoaded", null, {
                    page: m
                })
            });
            e.appended = false
        },
        next: function() {
            var b = this.options,
                c = a(this.element).data("data");
            if (!c.animated) {
                c.animated = true;
                if (!c.appended) {
                    ++c.pageIndex
                }
                if (c.pageIndex > c.pages.length - 1) {
                    c.pageIndex = 0
                }
                this._goToNextPage(c.pageIndex - c.oldPageIndex);
                c.oldPageIndex = c.pageIndex
            }
        },
        prev: function() {
            var b = this.options,
                c = a(this.element).data("data");
            if (!c.animated) {
                c.animated = true;
                if (!c.appended) {
                    --c.pageIndex
                }
                if (c.pageIndex < 0) {
                    c.pageIndex = c.pages.length - 1
                }
                this._goToPrevPage(c.pageIndex - c.oldPageIndex);
                c.oldPageIndex = c.pageIndex
            }
        },
        _removeOldElements: function(b, d) {
            var e = a(this.element);
            for (var c = 0; c < d; c++) {
                if (b === "first") {
                    e.find("div.wrapper").children().first().remove()
                } else {
                    e.find("div.wrapper").children().last().remove()
                }
            }
        },
        _saveElements: function() {
            var b, e = a(this.element),
                c = e.find("div.wrapper").children(),
                d = e.data("data");
            c.each(function(f, g) {
                b = a(g);
                d.paths.push(b.clone(true, true));
                b.remove()
            })
        },
        _setOption: function(c, f) {
            var e, b = this.options,
                d = a(this.element).data("data");
            switch (c) {
                case "speed":
                    this._checkOptionsValidity({
                        speed: f
                    });
                    b.speed = f;
                    a.Widget.prototype._setOption.apply(this, arguments);
                    break;
                case "auto":
                    e = a.extend(b.auto, f);
                    this._checkOptionsValidity({
                        auto: e
                    });
                    if (b.auto.enabled) {
                        this._autoMode(b.auto.direction)
                    }
            }
        },
        _setStep: function(d) {
            var c, b = this.options,
                e = a(this.element).data("data");
            c = d || b.step;
            b.step = c;
            e.step = b.width * c
        },
        _setCarouselHeight: function() {
            var b, e = a(this.element),
                d = a(this.element).data("data"),
                c = this.options;
            if (c.orientation === "vertical") {
                b = c.visible * c.height + c.margin * (c.visible - 1)
            } else {
                b = c.height
            }
            e.height(b)
        },
        _setCarouselWidth: function() {
            var d, e = a(this.element),
                b = this.options,
                c = a(this.element).data("data");
            if (b.orientation === "horizontal") {
                d = b.visible * b.width + b.margin * (b.visible - 1)
            } else {
                d = b.width
            }
            e.css({
                width: d,
                overflow: "hidden"
            })
        },
        options: {
            visible: 3,
            step: 3,
            width: 100,
            height: 100,
            speed: 1000,
            margin: 0,
            orientation: "horizontal",
            auto: {
                enabled: false,
                direction: "next",
                interval: 5000
            },
            startAtPage: 0,
            navigation: {
                next: "#ui-carousel-next",
                prev: "#ui-carousel-prev"
            }
        }
    })
}(jQuery));
/*jquery.ui.caurousel.min.js end*/

/* Pan Joom js*/
! function(a) {
    a.fn.imagePanning = function() {
        var b = "center",
            c = 800,
            d = function(a, b, c, d, e, f) {
                function o() {
                    i = t() - g, p(), i >= m.time && (m.time = i > m.time ? i + h - (i - m.time) : i + h - 1, m.time < i + 1 && (m.time = i + 1)), m.time < d && (m.id = l(o))
                }

                function p() {
                    d > 0 ? (m.currVal = s(m.time, j, n, d, e), k[b] = Math.round(m.currVal) + "px") : k[b] = c + "px"
                }

                function q() {
                    h = 1e3 / 60, m.time = i + h, l = window.requestAnimationFrame ? window.requestAnimationFrame : function(a) {
                        return p(), setTimeout(a, .01)
                    }, m.id = l(o)
                }

                function r() {
                    null != m.id && (window.requestAnimationFrame ? window.cancelAnimationFrame(m.id) : clearTimeout(m.id), m.id = null)
                }

                function s(a, b, c, d, e) {
                    var f = (a /= d) * a,
                        g = f * a;
                    return b + c * (.499999999999997 * g * f + -2.5 * f * f + 5.5 * g + -6.5 * f + 4 * a)
                }

                function t() {
                    return window.performance && window.performance.now ? window.performance.now() : window.performance && window.performance.webkitNow ? window.performance.webkitNow() : Date.now ? Date.now() : (new Date).getTime()
                }
                a._mTween || (a._mTween = {
                    top: {},
                    left: {}
                });
                var h, l, g = t(),
                    i = 0,
                    j = a.offsetTop,
                    k = a.style,
                    m = a._mTween[b];
                "left" === b && (j = a.offsetLeft);
                var n = c - j;
                "none" !== f && r(), q()
            };
        return this.each(function() {
            var f, g, e = a(this);
            e.data("imagePanning") || (e.data("imagePanning", 1).wrap("<div class='img-pan-container' />").after("<div class='resize' style='position:absolute; width:auto; height:auto; top:0; right:0; bottom:0; left:0; margin:0; padding:0; overflow:hidden; visibility:hidden; z-index:-1'><iframe style='width:100%; height:0; border:0; visibility:visible; margin:0' /><iframe style='width:0; height:100%; border:0; visibility:visible; margin:0' /></div>").one("load", function() {
                setTimeout(function() {
                    e.addClass("loaded").trigger("mousemove", 1)
                }, 1)
            }).each(function() {
                this.complete && a(this).load()
            }).parent().on("mousemove touchmove MSPointerMove pointermove", function(c, d) {
                var f = a(this);
                c.preventDefault();
                var h = f.height(),
                    i = f.width(),
                    j = c.type.indexOf("touch") !== -1,
                    k = c.type.indexOf("pointer") !== -1,
                    l = k ? c.originalEvent : j ? c.originalEvent.touches[0] || c.originalEvent.changedTouches[0] : c,
                    m = [d ? "center" === b ? h / 2 : 0 : l.pageY - f.offset().top, d ? "center" === b ? i / 2 : 0 : l.pageX - f.offset().left];
                g = [Math.round((e.outerHeight(!0) - h) * (m[0] / h)), Math.round((e.outerWidth(!0) - i) * (m[1] / i))]
            }).find(".resize iframe").each(function() {
                a(this.contentWindow || this).on("resize", function() {
                    e.trigger("mousemove", 1)
                })
            }), f && clearInterval(f), f = setInterval(function() {
                d(e[0], "top", -g[0], c), d(e[0], "left", -g[1], c)
            }, 16.6))
        })
    }
}(jQuery);