// const sizeSidebar = "-ml-[155px]";

document.addEventListener('DOMContentLoaded', () => {
    lucide.createIcons({
        attrs: {
            class: ['size-4 stroke-[1.5] [--color:currentColor] stroke-(--color) fill-(--color)/25'],
            // 'stroke-width': 1,
            stroke: 'currentColor'
        },
        icons: lucide.icons
    })
    const sizeSidebar = "";
    (() => {
        var l = (e, r = 300, s = (o) => { }) => {
            (e.style.transitionProperty = "height, margin, padding"),
                (e.style.transitionDuration = r + "ms"),
                (e.style.height = e.offsetHeight + "px"),
                e.offsetHeight,
                (e.style.overflow = "hidden"),
                (e.style.height = "0"),
                (e.style.paddingTop = "0"),
                (e.style.paddingBottom = "0"),
                (e.style.marginTop = "0"),
                (e.style.marginBottom = "0"),
                window.setTimeout(() => {
                    (e.style.display = "none"),
                        e.style.removeProperty("height"),
                        e.style.removeProperty("padding-top"),
                        e.style.removeProperty("padding-bottom"),
                        e.style.removeProperty("margin-top"),
                        e.style.removeProperty("margin-bottom"),
                        e.style.removeProperty("overflow"),
                        e.style.removeProperty("transition-duration"),
                        e.style.removeProperty("transition-property"),
                        s(e);
                }, r);
        },
            a = (e, r = 300, s = (o) => { }) => {
                e.style.removeProperty("display");
                let o = window.getComputedStyle(e).display;
                o === "none" && (o = "block"), (e.style.display = o);
                let t = e.offsetHeight;
                (e.style.overflow = "hidden"),
                    (e.style.height = "0"),
                    (e.style.paddingTop = "0"),
                    (e.style.paddingBottom = "0"),
                    (e.style.marginTop = "0"),
                    (e.style.marginBottom = "0"),
                    e.offsetHeight,
                    (e.style.transitionProperty = "height, margin, padding"),
                    (e.style.transitionDuration = r + "ms"),
                    (e.style.height = t + "px"),
                    e.style.removeProperty("padding-top"),
                    e.style.removeProperty("padding-bottom"),
                    e.style.removeProperty("margin-top"),
                    e.style.removeProperty("margin-bottom"),
                    window.setTimeout(() => {
                        e.style.removeProperty("height"), e.style.removeProperty("overflow"), e.style.removeProperty("transition-duration"), e.style.removeProperty("transition-property"), s(e);
                    }, r);
            },
            m = (e, r = {}) => {
                let s = {},
                    o = new Proxy(e, {
                        set(t, n, i) {
                            let c = t[n];
                            return (t[n] = i), r[n] && r[n](i, c), s[n] && s[n].forEach((d) => d()), !0;
                        },
                    });
                return (
                    (o.onChange = (t, n) => {
                        t.forEach((i) => {
                            s[i] || (s[i] = []), s[i].push(n);
                        }),
                            n();
                    }),
                    o
                );
            };
        (function () {
            "use strict";
            let e = m({ compactMenu: !0, compactMenuOnHover: !1, mobileMenuOpen: !1 });
            e.onChange(["compactMenu", "compactMenuOnHover", "mobileMenuOpen"], () => {
                e.compactMenu ? $(".side-menu")
                    .first()
                    // .addClass("side-menu--collapsed")
                    .addClass("")
                    : $(".side-menu")
                        .first()
                        // .removeClass("side-menu--collapsed")
                        .removeClass('')
                    ,
                    e.compactMenuOnHover ? $(".side-menu").first().addClass("side-menu--on-hover") : $(".side-menu").first().removeClass("side-menu--on-hover"),
                    e.mobileMenuOpen
                        ? ($(".side-menu").first().addClass("side-menu--mobile-menu-open"), $(".close-mobile-menu").first().addClass("close-mobile-menu--mobile-menu-open"), $(".top-menu").first().addClass("top-menu--mobile-menu-open"))
                        : ($(".side-menu").first().removeClass("side-menu--mobile-menu-open"),
                            $(".close-mobile-menu").first().removeClass("close-mobile-menu--mobile-menu-open"),
                            $(".top-menu").first().removeClass("top-menu--mobile-menu-open")),
                    e.compactMenu && !e.compactMenuOnHover ? $(".content").first().addClass("content--compact") : $(".content").first().removeClass("content--compact"),
                    e.compactMenu && e.compactMenuOnHover && !e.mobileMenuOpen ? $(".content__scroll-area")
                        .first()
                        .addClass(sizeSidebar) : $(".content__scroll-area")
                            .first()
                            .removeClass(sizeSidebar);
            }),
                $(".side-menu").on("mouseover", function () {
                    e.compactMenuOnHover = !0;
                }),
                $(".side-menu").on("mouseleave", function () {
                    e.compactMenuOnHover = !1;
                }),
                $(".toggle-compact-menu").on("click", function (o) {
                    o.preventDefault(), (e.compactMenu = !e.compactMenu), localStorage.setItem("compactMenu", e.compactMenu);
                }),
                $(".open-mobile-menu").on("click", function (o) {
                    o.preventDefault(), (e.mobileMenuOpen = !0);
                }),
                $(".close-mobile-menu").on("click", function (o) {
                    o.preventDefault(), (e.mobileMenuOpen = !1);
                });
            let r = {
                getDarkMode() {
                    let o = localStorage.getItem("darkMode");
                    return o === null ? "inactive" : o === "system" ? (window.matchMedia("(prefers-color-scheme:dark)").matches ? "active" : "inactive") : o;
                },
                toggleDarkMode(o) {
                    localStorage.setItem("darkMode", o), r.applyDarkMode();
                },
                applyDarkMode() {
                    r.getDarkMode() === "active" ? $("html").addClass("dark") : $("html").removeClass("dark");
                },
            },
                s = {
                    getThemeColor() {
                        let o = localStorage.getItem("themeColor");
                        return o === null ? "default" : o;
                    },
                    setThemeColor(o) {
                        localStorage.setItem("themeColor", o), s.applyThemeColor();
                    },
                    applyThemeColor() {
                        $("html").data("theme", s.getThemeColor());
                    },
                };
            $(".content__scroll-area").on("scroll", function () {
                $(this)[0].scrollTop > 0 ? $(".top-bar").addClass("scrolled") : $(".top-bar").removeClass("scrolled");
            }),
                (function () {
                    $(".scrollable").each(function () {
                        let o = new SimpleBar($(this).parent()[0]);
                        const _linkActive = o.getScrollElement().scrollTop = $(".side-menu__link--active")[0]
                        if (_linkActive) {
                            _linkActive.getBoundingClientRect().top - 250;
                        }
                    });
                })(),
                (function () {
                    $(".scrollable")
                        .find("li")
                        .children("a")
                        .on("click", function (o) {
                            let t = $(this).parent().children("ul")[0];
                            t
                                ? $(t).hasClass("block")
                                    ? ($(this).find(".side-menu__link__chevron").removeClass("transform rotate-180"),
                                        l(t, 300, () => {
                                            $(t).removeClass("block").addClass("hidden");
                                        }))
                                    : ($(this).find(".side-menu__link__chevron").addClass("transform rotate-180"),
                                        a(t, 300, () => {
                                            $(t).removeClass("hidden").addClass("block");
                                        }))
                                : (o.preventDefault(), (window.location.href = $(this).attr("href")));
                        });
                })(),
                (function () {
                    $(".top-menu")
                        .find("li")
                        .children("a")
                        .on("click", function (o) {
                            let t = $(this).parent().children("ul")[0];
                            t
                                ? $(t).hasClass("block")
                                    ? ($(this).find(".top-menu__link__chevron").removeClass("transform rotate-180"),
                                        l(t, 300, () => {
                                            $(t).removeClass("block").addClass("hidden");
                                        }))
                                    : ($(this).find(".top-menu__link__chevron").addClass("transform rotate-180"),
                                        a(t, 300, () => {
                                            $(t).removeClass("hidden").addClass("block");
                                        }))
                                : (o.preventDefault(), (window.location.href = $(this).attr("href")));
                        });
                })(),
                (function () {
                    let o = $("#quick-search-modal")[0];
                    if (o) {
                        let t = tailwind.Modal.getOrCreateInstance(o);
                        $("body").on("keydown", function (n) {
                            n.key === "Escape" ? t.hide() : n.metaKey && n.key === "k" && t.show();
                        }),
                            $(".quick-search-toggle").on("click", function (n) {
                                t.show();
                            });
                    }
                })(),
                (function () {
                    let o = localStorage.getItem("compactMenu");
                    (o === null || o == "false") && (e.compactMenu = !1),
                        (window.onresize = () => {
                            window.innerWidth <= 1600 && (localStorage.setItem("compactMenu", "true"), (e.compactMenu = !0));
                        }),
                        r.applyDarkMode(),
                        s.applyThemeColor();
                })();
        })();
    })();


});
