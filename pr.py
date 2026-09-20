function buildTeeth(sel, count, inner, outer, w) {
  var g = root.querySelector(sel);
  if (!g) return;
  for (var i = 0; i < count; i++) {
    var r = document.createElementNS(SVG, 'rect');
    r.setAttribute('class', 'vdp-tooth');
    r.setAttribute('x', String(-w / 2));
    r.setAttribute('y', String(-outer));
    r.setAttribute('width', String(w));
    r.setAttribute('height', String(outer - inner + 1)
);
    r.setAttribute('transform', 'rotate(' + (i * 360 / 
count) + ')');
    g.appendChild(r);
  }
}