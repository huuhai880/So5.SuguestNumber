(function(e) {
    function n(n) {
        for (var a, r, u = n[0], o = n[1], f = n[2], i = 0, d = []; i < u.length; i++) r = u[i], Object.prototype.hasOwnProperty.call(c, r) && c[r] && d.push(c[r][0]), c[r] = 0;
        for (a in o) Object.prototype.hasOwnProperty.call(o, a) && (e[a] = o[a]);
        l && l(n);
        while (d.length) d.shift()();
        return s.push.apply(s, f || []), t()
    }

    function t() {
        for (var e, n = 0; n < s.length; n++) {
            for (var t = s[n], a = !0, r = 1; r < t.length; r++) {
                var u = t[r];
                0 !== c[u] && (a = !1)
            }
            a && (s.splice(n--, 1), e = o(o.s = t[0]))
        }
        return e
    }
    var a = {},
        r = {
            app: 0
        },
        c = {
            app: 0
        },
        s = [];

    function u(e) {
        return o.p + "js/" + ({} [e] || e) + "." + {
            "chunk-06bbad72": "4ddf5414",
            "chunk-33f00d56": "52b9952b",
            "chunk-358a38d0": "3894c6a7",
            "chunk-4103208a": "eead9f68",
            "chunk-4c9f040f": "3597a14f",
            "chunk-523877c5": "f48a5c47",
            "chunk-67b3463f": "ea3a65f0",
            "chunk-0eaf16a5": "2d6ad481",
            "chunk-8b3ee5b8": "bf8399de",
            "chunk-8c505fd6": "77251e8d",
            "chunk-9ca03aca": "82d9c1b9",
            "chunk-b62f87a0": "17c81025",
            "chunk-29781ef8": "011f8ddd",
            "chunk-3120f96c": "98026ecb",
            "chunk-42bf33e4": "e0b0042a",
            "chunk-63265917": "56f5bc9e",
            "chunk-71438fb3": "9e43445b",
            "chunk-e5e8590c": "57a5bcc4",
            "chunk-e4ea1cd6": "068e6766",
            "chunk-6fedeada": "16a270b8",
            "chunk-7ad1f370": "dd5573b3",
            "chunk-8fc1653a": "fde267d1"
        } [e] + ".js"
    }

    function o(n) {
        if (a[n]) return a[n].exports;
        var t = a[n] = {
            i: n,
            l: !1,
            exports: {}
        };
        return e[n].call(t.exports, t, t.exports, o), t.l = !0, t.exports
    }
    o.e = function(e) {
        var n = [],
            t = {
                "chunk-33f00d56": 1,
                "chunk-358a38d0": 1,
                "chunk-4c9f040f": 1,
                "chunk-523877c5": 1,
                "chunk-0eaf16a5": 1,
                "chunk-8b3ee5b8": 1,
                "chunk-8c505fd6": 1,
                "chunk-9ca03aca": 1,
                "chunk-b62f87a0": 1,
                "chunk-29781ef8": 1,
                "chunk-42bf33e4": 1,
                "chunk-63265917": 1,
                "chunk-71438fb3": 1,
                "chunk-e5e8590c": 1,
                "chunk-e4ea1cd6": 1,
                "chunk-6fedeada": 1,
                "chunk-7ad1f370": 1,
                "chunk-8fc1653a": 1
            };
        r[e] ? n.push(r[e]) : 0 !== r[e] && t[e] && n.push(r[e] = new Promise((function(n, t) {
            for (var a = "css/" + ({} [e] || e) + "." + {
                    "chunk-06bbad72": "31d6cfe0",
                    "chunk-33f00d56": "88b372bc",
                    "chunk-358a38d0": "cfb47f59",
                    "chunk-4103208a": "31d6cfe0",
                    "chunk-4c9f040f": "a2978806",
                    "chunk-523877c5": "0bfef931",
                    "chunk-67b3463f": "31d6cfe0",
                    "chunk-0eaf16a5": "6a801d2f",
                    "chunk-8b3ee5b8": "56982e40",
                    "chunk-8c505fd6": "0e3187f8",
                    "chunk-9ca03aca": "d5a982f4",
                    "chunk-b62f87a0": "2cf2df8c",
                    "chunk-29781ef8": "90b6bdf1",
                    "chunk-3120f96c": "31d6cfe0",
                    "chunk-42bf33e4": "b9018fd1",
                    "chunk-63265917": "1484d047",
                    "chunk-71438fb3": "e3bede3e",
                    "chunk-e5e8590c": "221906ed",
                    "chunk-e4ea1cd6": "4ff30720",
                    "chunk-6fedeada": "b2a2b25c",
                    "chunk-7ad1f370": "a183fec0",
                    "chunk-8fc1653a": "6ff6b4dc"
                } [e] + ".css", c = o.p + a, s = document.getElementsByTagName("link"), u = 0; u < s.length; u++) {
                var f = s[u],
                    i = f.getAttribute("data-href") || f.getAttribute("href");
                if ("stylesheet" === f.rel && (i === a || i === c)) return n()
            }
            var d = document.getElementsByTagName("style");
            for (u = 0; u < d.length; u++) {
                f = d[u], i = f.getAttribute("data-href");
                if (i === a || i === c) return n()
            }
            var l = document.createElement("link");
            l.rel = "stylesheet", l.type = "text/css", l.onload = n, l.onerror = function(n) {
                var a = n && n.target && n.target.src || c,
                    s = new Error("Loading CSS chunk " + e + " failed.\n(" + a + ")");
                s.code = "CSS_CHUNK_LOAD_FAILED", s.request = a, delete r[e], l.parentNode.removeChild(l), t(s)
            }, l.href = c;
            var b = document.getElementsByTagName("head")[0];
            b.appendChild(l)
        })).then((function() {
            r[e] = 0
        })));
        var a = c[e];
        if (0 !== a)
            if (a) n.push(a[2]);
            else {
                var s = new Promise((function(n, t) {
                    a = c[e] = [n, t]
                }));
                n.push(a[2] = s);
                var f, i = document.createElement("script");
                i.charset = "utf-8", i.timeout = 120, o.nc && i.setAttribute("nonce", o.nc), i.src = u(e);
                var d = new Error;
                f = function(n) {
                    i.onerror = i.onload = null, clearTimeout(l);
                    var t = c[e];
                    if (0 !== t) {
                        if (t) {
                            var a = n && ("load" === n.type ? "missing" : n.type),
                                r = n && n.target && n.target.src;
                            d.message = "Loading chunk " + e + " failed.\n(" + a + ": " + r + ")", d.name = "ChunkLoadError", d.type = a, d.request = r, t[1](d)
                        }
                        c[e] = void 0
                    }
                };
                var l = setTimeout((function() {
                    f({
                        type: "timeout",
                        target: i
                    })
                }), 12e4);
                i.onerror = i.onload = f, document.head.appendChild(i)
            } return Promise.all(n)
    }, o.m = e, o.c = a, o.d = function(e, n, t) {
        o.o(e, n) || Object.defineProperty(e, n, {
            enumerable: !0,
            get: t
        })
    }, o.r = function(e) {
        "undefined" !== typeof Symbol && Symbol.toStringTag && Object.defineProperty(e, Symbol.toStringTag, {
            value: "Module"
        }), Object.defineProperty(e, "__esModule", {
            value: !0
        })
    }, o.t = function(e, n) {
        if (1 & n && (e = o(e)), 8 & n) return e;
        if (4 & n && "object" === typeof e && e && e.__esModule) return e;
        var t = Object.create(null);
        if (o.r(t), Object.defineProperty(t, "default", {
                enumerable: !0,
                value: e
            }), 2 & n && "string" != typeof e)
            for (var a in e) o.d(t, a, function(n) {
                return e[n]
            }.bind(null, a));
        return t
    }, o.n = function(e) {
        var n = e && e.__esModule ? function() {
            return e["default"]
        } : function() {
            return e
        };
        return o.d(n, "a", n), n
    }, o.o = function(e, n) {
        return Object.prototype.hasOwnProperty.call(e, n)
    }, o.p = "/", o.oe = function(e) {
        throw console.error(e), e
    };
    var f = window["webpackJsonp"] = window["webpackJsonp"] || [],
        i = f.push.bind(f);
    f.push = n, f = f.slice();
    for (var d = 0; d < f.length; d++) n(f[d]);
    var l = i;
    s.push([0, "chunk-vendors"]), t()
})({
    0: function(e, n, t) {
        e.exports = t("56d7")
    },
    "15bd": function(e, n, t) {},
    4678: function(e, n, t) {
        var a = {
            "./af": "2bfb",
            "./af.js": "2bfb",
            "./ar": "8e73",
            "./ar-dz": "a356",
            "./ar-dz.js": "a356",
            "./ar-kw": "423e",
            "./ar-kw.js": "423e",
            "./ar-ly": "1cfd",
            "./ar-ly.js": "1cfd",
            "./ar-ma": "0a84",
            "./ar-ma.js": "0a84",
            "./ar-sa": "8230",
            "./ar-sa.js": "8230",
            "./ar-tn": "6d83",
            "./ar-tn.js": "6d83",
            "./ar.js": "8e73",
            "./az": "485c",
            "./az.js": "485c",
            "./be": "1fc1",
            "./be.js": "1fc1",
            "./bg": "84aa",
            "./bg.js": "84aa",
            "./bm": "a7fa",
            "./bm.js": "a7fa",
            "./bn": "9043",
            "./bn-bd": "9686",
            "./bn-bd.js": "9686",
            "./bn.js": "9043",
            "./bo": "d26a",
            "./bo.js": "d26a",
            "./br": "6887",
            "./br.js": "6887",
            "./bs": "2554",
            "./bs.js": "2554",
            "./ca": "d716",
            "./ca.js": "d716",
            "./cs": "3c0d",
            "./cs.js": "3c0d",
            "./cv": "03ec",
            "./cv.js": "03ec",
            "./cy": "9797",
            "./cy.js": "9797",
            "./da": "0f14",
            "./da.js": "0f14",
            "./de": "b469",
            "./de-at": "b3eb",
            "./de-at.js": "b3eb",
            "./de-ch": "bb71",
            "./de-ch.js": "bb71",
            "./de.js": "b469",
            "./dv": "598a",
            "./dv.js": "598a",
            "./el": "8d47",
            "./el.js": "8d47",
            "./en-au": "0e6b",
            "./en-au.js": "0e6b",
            "./en-ca": "3886",
            "./en-ca.js": "3886",
            "./en-gb": "39a6",
            "./en-gb.js": "39a6",
            "./en-ie": "e1d3",
            "./en-ie.js": "e1d3",
            "./en-il": "7333",
            "./en-il.js": "7333",
            "./en-in": "ec2e",
            "./en-in.js": "ec2e",
            "./en-nz": "6f50",
            "./en-nz.js": "6f50",
            "./en-sg": "b7e9",
            "./en-sg.js": "b7e9",
            "./eo": "65db",
            "./eo.js": "65db",
            "./es": "898b",
            "./es-do": "0a3c",
            "./es-do.js": "0a3c",
            "./es-mx": "b5b7",
            "./es-mx.js": "b5b7",
            "./es-us": "55c9",
            "./es-us.js": "55c9",
            "./es.js": "898b",
            "./et": "ec18",
            "./et.js": "ec18",
            "./eu": "0ff2",
            "./eu.js": "0ff2",
            "./fa": "8df4",
            "./fa.js": "8df4",
            "./fi": "81e9",
            "./fi.js": "81e9",
            "./fil": "d69a",
            "./fil.js": "d69a",
            "./fo": "0721",
            "./fo.js": "0721",
            "./fr": "9f26",
            "./fr-ca": "d9f8",
            "./fr-ca.js": "d9f8",
            "./fr-ch": "0e49",
            "./fr-ch.js": "0e49",
            "./fr.js": "9f26",
            "./fy": "7118",
            "./fy.js": "7118",
            "./ga": "5120",
            "./ga.js": "5120",
            "./gd": "f6b4",
            "./gd.js": "f6b4",
            "./gl": "8840",
            "./gl.js": "8840",
            "./gom-deva": "aaf2",
            "./gom-deva.js": "aaf2",
            "./gom-latn": "0caa",
            "./gom-latn.js": "0caa",
            "./gu": "e0c5",
            "./gu.js": "e0c5",
            "./he": "c7aa",
            "./he.js": "c7aa",
            "./hi": "dc4d",
            "./hi.js": "dc4d",
            "./hr": "4ba9",
            "./hr.js": "4ba9",
            "./hu": "5b14",
            "./hu.js": "5b14",
            "./hy-am": "d6b6",
            "./hy-am.js": "d6b6",
            "./id": "5038",
            "./id.js": "5038",
            "./is": "0558",
            "./is.js": "0558",
            "./it": "6e98",
            "./it-ch": "6f12",
            "./it-ch.js": "6f12",
            "./it.js": "6e98",
            "./ja": "079e",
            "./ja.js": "079e",
            "./jv": "b540",
            "./jv.js": "b540",
            "./ka": "201b",
            "./ka.js": "201b",
            "./kk": "6d79",
            "./kk.js": "6d79",
            "./km": "e81d",
            "./km.js": "e81d",
            "./kn": "3e92",
            "./kn.js": "3e92",
            "./ko": "22f8",
            "./ko.js": "22f8",
            "./ku": "2421",
            "./ku.js": "2421",
            "./ky": "9609",
            "./ky.js": "9609",
            "./lb": "440c",
            "./lb.js": "440c",
            "./lo": "b29d",
            "./lo.js": "b29d",
            "./lt": "26f9",
            "./lt.js": "26f9",
            "./lv": "b97c",
            "./lv.js": "b97c",
            "./me": "293c",
            "./me.js": "293c",
            "./mi": "688b",
            "./mi.js": "688b",
            "./mk": "6909",
            "./mk.js": "6909",
            "./ml": "02fb",
            "./ml.js": "02fb",
            "./mn": "958b",
            "./mn.js": "958b",
            "./mr": "39bd",
            "./mr.js": "39bd",
            "./ms": "ebe4",
            "./ms-my": "6403",
            "./ms-my.js": "6403",
            "./ms.js": "ebe4",
            "./mt": "1b45",
            "./mt.js": "1b45",
            "./my": "8689",
            "./my.js": "8689",
            "./nb": "6ce3",
            "./nb.js": "6ce3",
            "./ne": "3a39",
            "./ne.js": "3a39",
            "./nl": "facd",
            "./nl-be": "db29",
            "./nl-be.js": "db29",
            "./nl.js": "facd",
            "./nn": "b84c",
            "./nn.js": "b84c",
            "./oc-lnc": "167b",
            "./oc-lnc.js": "167b",
            "./pa-in": "f3ff",
            "./pa-in.js": "f3ff",
            "./pl": "8d57",
            "./pl.js": "8d57",
            "./pt": "f260",
            "./pt-br": "d2d4",
            "./pt-br.js": "d2d4",
            "./pt.js": "f260",
            "./ro": "972c",
            "./ro.js": "972c",
            "./ru": "957c",
            "./ru.js": "957c",
            "./sd": "6784",
            "./sd.js": "6784",
            "./se": "ffff",
            "./se.js": "ffff",
            "./si": "eda5",
            "./si.js": "eda5",
            "./sk": "7be6",
            "./sk.js": "7be6",
            "./sl": "8155",
            "./sl.js": "8155",
            "./sq": "c8f3",
            "./sq.js": "c8f3",
            "./sr": "cf1e",
            "./sr-cyrl": "13e9",
            "./sr-cyrl.js": "13e9",
            "./sr.js": "cf1e",
            "./ss": "52bd",
            "./ss.js": "52bd",
            "./sv": "5fbd",
            "./sv.js": "5fbd",
            "./sw": "74dc",
            "./sw.js": "74dc",
            "./ta": "3de5",
            "./ta.js": "3de5",
            "./te": "5cbb",
            "./te.js": "5cbb",
            "./tet": "576c",
            "./tet.js": "576c",
            "./tg": "3b1b",
            "./tg.js": "3b1b",
            "./th": "10e8",
            "./th.js": "10e8",
            "./tk": "5aff",
            "./tk.js": "5aff",
            "./tl-ph": "0f38",
            "./tl-ph.js": "0f38",
            "./tlh": "cf755",
            "./tlh.js": "cf755",
            "./tr": "0e81",
            "./tr.js": "0e81",
            "./tzl": "cf51",
            "./tzl.js": "cf51",
            "./tzm": "c109",
            "./tzm-latn": "b53d",
            "./tzm-latn.js": "b53d",
            "./tzm.js": "c109",
            "./ug-cn": "6117",
            "./ug-cn.js": "6117",
            "./uk": "ada2",
            "./uk.js": "ada2",
            "./ur": "5294",
            "./ur.js": "5294",
            "./uz": "2e8c",
            "./uz-latn": "010e",
            "./uz-latn.js": "010e",
            "./uz.js": "2e8c",
            "./vi": "2921",
            "./vi.js": "2921",
            "./x-pseudo": "fd7e",
            "./x-pseudo.js": "fd7e",
            "./yo": "7f33",
            "./yo.js": "7f33",
            "./zh-cn": "5c3a",
            "./zh-cn.js": "5c3a",
            "./zh-hk": "49ab",
            "./zh-hk.js": "49ab",
            "./zh-mo": "3a6c",
            "./zh-mo.js": "3a6c",
            "./zh-tw": "90ea",
            "./zh-tw.js": "90ea"
        };

        function r(e) {
            var n = c(e);
            return t(n)
        }

        function c(e) {
            if (!t.o(a, e)) {
                var n = new Error("Cannot find module '" + e + "'");
                throw n.code = "MODULE_NOT_FOUND", n
            }
            return a[e]
        }
        r.keys = function() {
            return Object.keys(a)
        }, r.resolve = c, e.exports = r, r.id = "4678"
    },
    "56d7": function(e, n, t) {
        "use strict";
        t.r(n);
        t("4de4"), t("45fc"), t("b0c0"), t("d3b7"), t("3ca3"), t("ddb0"), t("e260"), t("e6cf"), t("cca6"), t("a79d");
        var a, r = t("2b0e"),
            c = function() {
                var e = this,
                    n = e.$createElement,
                    t = e._self._c || n;
                return t("div", {
                    staticClass: "z-theme-dark_",
                    attrs: {
                        id: "app"
                    }
                }, [t("router-view")], 1)
            },
            s = [],
            u = (t("96cf"), t("1da1")),
            o = {
                name: "App",
                data: function() {
                    return {
                        refreshing: !1,
                        registration: null
                    }
                },
                created: function() {
                    this.$workbox && this.$workbox.addEventListener("waiting", this.update)
                },
                methods: {
                    update: function() {
                        var e = this;
                        return Object(u["a"])(regeneratorRuntime.mark((function n() {
                            return regeneratorRuntime.wrap((function(n) {
                                while (1) switch (n.prev = n.next) {
                                    case 0:
                                        return n.next = 2, e.$workbox.messageSW({
                                            type: "SKIP_WAITING"
                                        });
                                    case 2:
                                    case "end":
                                        return n.stop()
                                }
                            }), n)
                        })))()
                    }
                }
            },
            f = o,
            i = t("2877"),
            d = Object(i["a"])(f, c, s, !1, null, null, null),
            l = d.exports,
            b = t("acfa");
        "serviceWorker" in navigator ? (a = new b["a"]("".concat("/", "service-worker.js")), a.addEventListener("controlling", (function() {
            window.location.reload()
        })), a.register()) : a = null;
        var h = a,
            p = t("2f62"),
            m = t("5530"),
            j = t("bfa9");

        function g() {
            var e = arguments.length > 0 && void 0 !== arguments[0] ? arguments[0] : {};
            return function(n) {
                var t = new j["a"](Object(m["a"])(Object(m["a"])({}, e), {}, {
                    restoreState: function(e, n) {
                        var t = JSON.parse(n.getItem(e));
                        return t
                    }
                }));
                return t.plugin(n)
            }
        }
        var k = t("bc3a"),
            v = t.n(k);
        v.a.defaults.withCredentials = !0;
        var y = v.a.create({
                baseURL: "//api.lienquan5.com:8443/api/v1",
                headers: {
                    Accept: "application/json"
                }
            }),
            w = y,
            P = {
                user: null
            },
            S = {
                setUserData: function(e, n) {
                    e.user = n, localStorage.setItem("userInfo", JSON.stringify(n));
                    var t = 86400 + (new Date).getTime() / 1e3;
                    localStorage.setItem("expires_in", t)
                },
                clearUserData: function() {
                    localStorage.removeItem("userInfo"), localStorage.removeItem("expires_in"), window.document.cookie = "laravel_session=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;"
                }
            },
            O = {
                login: function(e, n) {
                    var t = e.commit;
                    return w.get("//".concat("api.lienquan5.com:8443", "/sanctum/csrf-cookie")).then((function(e) {
                        return console.log(e), w.post("//".concat("api.lienquan5.com:8443", "/login"), n).then((function(e) {
                            var n = e.data;
                            t("setUserData", n.data)
                        })).catch((function(e) {
                            if (e.response && 403 == e.response.status) return Promise.reject("Sai thông tin đăng nhập!")
                        }))
                    }))
                },
                logout: function(e) {
                    var n = e.commit;
                    n("clearUserData")
                },
                verify_auth: function(e) {
                    var n = e.commit,
                        t = localStorage.getItem("userInfo");
                    if (t) return new Promise((function(e, t) {
                        var a = parseInt(localStorage.getItem("expires_in"));
                        a - (new Date).getTime() / 1e3 <= 0 ? (n("clearUserData"), t()) : e()
                    }))
                }
            },
            z = {
                isLogged: function(e) {
                    return !!e.user
                },
                currentUser: function(e) {
                    return e.user
                }
            },
            _ = {
                state: P,
                actions: O,
                mutations: S,
                getters: z
            },
            x = {
                parseTypes: []
            },
            T = {
                setParseTypes: function(e, n) {
                    e.parseTypes = n
                }
            },
            I = {
                getParseTypes: function(e) {
                    var n = e.commit;
                    return w.get("setting/parses").then((function(e) {
                        n("setParseTypes", e.data.data)
                    }))
                }
            },
            D = {
                parseTypes: function(e) {
                    return e.parseTypes
                }
            },
            E = {
                state: x,
                actions: I,
                mutations: T,
                getters: D
            },
            L = {
                userSetting: []
            },
            C = {
                setUserSetting: function(e, n) {
                    e.userSetting = n
                }
            },
            M = {
                getUserSetting: function(e) {
                    var n = e.commit;
                    return w.get("user/setting").then((function(e) {
                        n("setUserSetting", e.data.data)
                    }))
                }
            },
            U = {
                userSetting: function(e) {
                    return e.userSetting
                }
            },
            $ = {
                state: L,
                actions: M,
                mutations: C,
                getters: U
            },
            N = {
                players: []
            },
            A = {
                setPlayers: function(e, n) {
                    e.players = n
                }
            },
            q = {
                getPlayers: function(e) {
                    var n = e.commit;
                    return w.get("players").then((function(e) {
                        n("setPlayers", e.data.data)
                    }))
                }
            },
            G = {
                players: function(e) {
                    return e.players
                }
            },
            B = {
                state: N,
                actions: q,
                mutations: A,
                getters: G
            },
            J = t("2ef0"),
            W = {
                game: {},
                channel: {},
                prop: {}
            },
            Y = {
                setGameMapping: function(e, n) {
                    e.game = n
                },
                setChannelMapping: function(e, n) {
                    e.channel = n
                },
                setPropMapping: function(e, n) {
                    e.prop = n
                }
            },
            R = {
                getGameMapping: function(e) {
                    var n = e.commit;
                    return w.get("game-mapping").then((function(e) {
                        n("setGameMapping", Object(J["groupBy"])(e.data.data.game, (function(e) {
                            return e.id
                        }))), n("setChannelMapping", Object(J["groupBy"])(e.data.data.channel, (function(e) {
                            return e.id
                        }))), n("setPropMapping", Object(J["groupBy"])(e.data.data.prop, (function(e) {
                            return e.id
                        })))
                    }))
                }
            },
            F = {
                game: function(e) {
                    return e.game
                },
                channel: function(e) {
                    return e.channel
                },
                prop: function(e) {
                    return e.prop
                }
            },
            K = {
                state: W,
                actions: R,
                mutations: Y,
                getters: F
            };
        r["default"].use(p["a"]);
        var H = [g({
                modules: ["parseTypes", "mapping", "userSetting"]
            })],
            Q = new p["a"].Store({
                state: {},
                mutations: {},
                actions: {},
                modules: {
                    auth: _,
                    parseTypes: E,
                    players: B,
                    mapping: K,
                    userSetting: $
                },
                plugins: H
            }),
            V = t("8c4f");
        r["default"].use(V["a"]);
        var X = [{
                path: "/login",
                component: function() {
                    return t.e("chunk-6fedeada").then(t.bind(null, "a55b"))
                },
                meta: {
                    rule: ["*"],
                    authPage: !0
                }
            }, {
                path: "",
                component: function() {
                    return t.e("chunk-33f00d56").then(t.bind(null, "cd56"))
                },
                children: [{
                    path: "/",
                    name: "home",
                    component: function() {
                        return t.e("chunk-4103208a").then(t.bind(null, "bb51"))
                    }
                }, {
                    path: "/customers",
                    name: "customers",
                    component: function() {
                        return t.e("chunk-06bbad72").then(t.bind(null, "0bcd"))
                    }
                }, {
                    path: "/customer-detail/:playerId?",
                    name: "customerDetail",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-8c505fd6")]).then(t.bind(null, "d086"))
                    },
                    meta: {
                        rule: ["*"],
                        parent: "customers"
                    }
                }, {
                    path: "/bet-list",
                    name: "betList",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-b62f87a0"), t.e("chunk-3120f96c"), t.e("chunk-63265917")]).then(t.bind(null, "1669"))
                    }
                }, {
                    path: "/bet-warning",
                    name: "betWarning",
                    component: function() {
                        return t.e("chunk-7ad1f370").then(t.bind(null, "8d97"))
                    }
                }, {
                    path: "/bet-sms",
                    name: "betSms",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-b62f87a0"), t.e("chunk-29781ef8")]).then(t.bind(null, "64d1"))
                    }
                }, {
                    path: "/report",
                    name: "report",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-b62f87a0"), t.e("chunk-3120f96c"), t.e("chunk-e5e8590c")]).then(t.bind(null, "8148"))
                    }
                }, {
                    path: "/sale",
                    name: "sale",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-b62f87a0"), t.e("chunk-e4ea1cd6")]).then(t.bind(null, "df7e"))
                    }
                }, {
                    path: "/users",
                    name: "users",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-0eaf16a5")]).then(t.bind(null, "ed81"))
                    }
                }, {
                    path: "/user/subs",
                    name: "subUsers",
                    component: function() {
                        return t.e("chunk-523877c5").then(t.bind(null, "2a43"))
                    }
                }, {
                    path: "/user/:uid?",
                    name: "userEdit",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-9ca03aca")]).then(t.bind(null, "da5c"))
                    },
                    meta: {
                        rule: ["*"],
                        parent: "users"
                    }
                }, {
                    path: "/report/player/:playerId",
                    name: "reportPlayerDetail",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-b62f87a0"), t.e("chunk-3120f96c"), t.e("chunk-42bf33e4")]).then(t.bind(null, "ec11"))
                    },
                    meta: {
                        parent: "report"
                    }
                }, {
                    path: "/report/summary",
                    name: "reportSummary",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-b62f87a0"), t.e("chunk-3120f96c"), t.e("chunk-71438fb3")]).then(t.bind(null, "845c"))
                    },
                    meta: {
                        parent: "report"
                    }
                }, {
                    path: "/bao-so/:playerId",
                    name: "baoSo",
                    component: function() {
                        return Promise.all([t.e("chunk-67b3463f"), t.e("chunk-8b3ee5b8")]).then(t.bind(null, "f851"))
                    }
                }, {
                    path: "/setting",
                    name: "setting",
                    component: function() {
                        return t.e("chunk-358a38d0").then(t.bind(null, "4ef5"))
                    },
                    meta: {
                        rule: ["*"],
                        parent: "userGroup"
                    }
                }, {
                    path: "/guide",
                    name: "guide",
                    component: function() {
                        return t.e("chunk-4c9f040f").then(t.bind(null, "4638"))
                    },
                    meta: {
                        rule: ["*"],
                        parent: "userGroup"
                    }
                }, {
                    path: "/change-pass",
                    name: "changePass",
                    component: function() {
                        return t.e("chunk-8fc1653a").then(t.bind(null, "4902"))
                    },
                    meta: {
                        rule: ["*"],
                        parent: "userGroup"
                    }
                }],
                meta: {
                    rule: ["*"]
                }
            }],
            Z = new V["a"]({
                mode: "history",
                base: "/",
                routes: X
            }),
            ee = Z,
            ne = t("4a7a"),
            te = t.n(ne),
            ae = function() {
                var e = this,
                    n = e.$createElement,
                    t = e._self._c || n;
                return t("router-link", {
                    staticClass: "button-back d-sm-none",
                    attrs: {
                        to: e.link
                    }
                }, [t("b-button", {
                    staticClass: "btn_p25 fz12",
                    attrs: {
                        variant: "outline-secondary_",
                        size: "sm"
                    }
                }, [t("b-icon", {
                    attrs: {
                        icon: "arrow-left"
                    }
                })], 1)], 1)
            },
            re = [],
            ce = {
                name: "button-back",
                props: ["link"],
                methods: {}
            },
            se = ce,
            ue = (t("fd8d"), Object(i["a"])(se, ae, re, !1, null, null, null)),
            oe = ue.exports,
            fe = t("5f5b"),
            ie = t("b1e0"),
            de = t("c38f"),
            le = t.n(de),
            be = t("4eb5"),
            he = t.n(be),
            pe = t("c1df"),
            me = t.n(pe);
        t("f9e3"), t("2dd8"), t("0952"), t("9494"), t("907d"), t("6dfc");
        r["default"].component("v-select", te.a);
        var je = r["default"].observable({
            value: !1
        });
        Object.defineProperty(r["default"].prototype, "$appLoading", {
            get: function() {
                return je.value
            },
            set: function(e) {
                je.value = e
            }
        }), r["default"].prototype.$http = w, r["default"].prototype.$workbox = h, r["default"].config.productionTip = !1, he.a.config.autoSetContainer = !0, r["default"].use(fe["a"]), r["default"].use(he.a), r["default"].use(ie["a"]), r["default"].use(le.a), r["default"].use(me.a), r["default"].component("button-back", oe), ee.beforeEach((function(e, n, t) {
            var a = localStorage.getItem("userInfo"),
                r = e.matched.some((function(e) {
                    return e.meta.authPage
                }));
            r || a || t("/login"), r || n.name == e.name ? t() : Promise.all([Q.dispatch("verify_auth")]).then(t).catch((function(e) {
                t("/login")
            }))
        })), new r["default"]({
            router: ee,
            store: Q,
            render: function(e) {
                return e(l)
            },
            created: function() {
                var e = this,
                    n = localStorage.getItem("userInfo");
                if (n) {
                    var t = JSON.parse(n);
                    e.$store.commit("setUserData", t)
                }
                w.interceptors.request.use((function(n) {
                    return e.$appLoading = !0, n
                }), (function(n) {
                    return e.$appLoading = !1, Promise.reject(n)
                })), w.interceptors.response.use((function(n) {
                    e.$appLoading = !1;
                    var t = 86400 + (new Date).getTime() / 1e3;
                    return localStorage.setItem("expires_in", t), n
                }), (function(n) {
                    return 401 === n.response.status && (e.$store.dispatch("logout"), window.location.reload()), e.$appLoading = !1, Promise.reject(n)
                }))
            }
        }).$mount("#app"), r["default"].filter("formatDate", (function(e) {
            if (e) return me()(String(e)).format("DD-MM-YYYY")
        }))
    },
    "907d": function(e, n, t) {},
    fd8d: function(e, n, t) {
        "use strict";
        t("15bd")
    }
});