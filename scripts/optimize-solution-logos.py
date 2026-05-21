#!/usr/bin/env python3
"""
Crop and resize solution brand logos to fit the aside brand box (360×72).

Run from theme root:
  python scripts/optimize-solution-logos.py
"""

from __future__ import annotations

import sys
from pathlib import Path

from PIL import Image, ImageChops

THEME_ROOT = Path(__file__).resolve().parents[1]
SOLUTIONS_DIR = THEME_ROOT / "assets" / "images" / "solutions"
TARGET_W, TARGET_H = 360, 72
PADDING = 4


def _luminance(r: int, g: int, b: int) -> float:
    return 0.2126 * r + 0.7152 * g + 0.0722 * b


def content_bbox(im: Image.Image, dark_threshold: int = 42) -> tuple[int, int, int, int]:
    """Bounding box of visible logo pixels (not dark background)."""
    rgba = im.convert("RGBA")
    w, h = rgba.size
    px = rgba.load()
    mask = Image.new("L", (w, h), 0)
    mpx = mask.load()

    for y in range(h):
        for x in range(w):
            r, g, b, a = px[x, y]
            if a < 16:
                continue
            lum = _luminance(r, g, b)
            if lum > dark_threshold:
                mpx[x, y] = 255
                continue
            # Colored marks (blue/cyan/orange) on dark backgrounds.
            if max(r, g, b) - min(r, g, b) > 22 and max(r, g, b) > 50:
                mpx[x, y] = 255
                continue
            # Light cyan bar-chart fills.
            if b > 90 and g > 70 and r < 120:
                mpx[x, y] = 255

    bbox = mask.getbbox()
    if bbox:
        return bbox
    return rgba.getbbox() or (0, 0, w, h)


def flatten_dark_to_white(im: Image.Image, threshold: int = 88) -> Image.Image:
    """Replace dark backgrounds with white (for JPEG logos)."""
    rgb = im.convert("RGB")
    px = rgb.load()
    w, h = rgb.size
    for y in range(h):
        for x in range(w):
            r, g, b = px[x, y]
            lum = _luminance(r, g, b)
            chroma = max(r, g, b) - min(r, g, b)
            if lum < threshold and chroma < 36:
                px[x, y] = (255, 255, 255)
    return rgb


def fit_on_canvas(
    im: Image.Image,
    canvas_w: int,
    canvas_h: int,
    padding: int,
    bg: tuple[int, ...],
    transparent: bool,
) -> Image.Image:
    crop = im.crop(content_bbox(im))
    inner_w = max(canvas_w - padding * 2, 1)
    inner_h = max(canvas_h - padding * 2, 1)
    scale = min(inner_w / crop.width, inner_h / crop.height)
    new_w = max(1, int(round(crop.width * scale)))
    new_h = max(1, int(round(crop.height * scale)))
    resized = crop.resize((new_w, new_h), Image.Resampling.LANCZOS)

    if transparent:
        canvas = Image.new("RGBA", (canvas_w, canvas_h), (0, 0, 0, 0))
        if resized.mode != "RGBA":
            resized = resized.convert("RGBA")
    else:
        canvas = Image.new("RGB", (canvas_w, canvas_h), bg[:3])

    x = (canvas_w - new_w) // 2
    y = (canvas_h - new_h) // 2
    if transparent:
        canvas.paste(resized, (x, y), resized)
    else:
        if resized.mode == "RGBA":
            flat = Image.new("RGB", resized.size, bg[:3])
            flat.paste(resized, mask=resized.split()[3])
            resized = flat
        else:
            resized = resized.convert("RGB")
        canvas.paste(resized, (x, y))

    return canvas


def knock_out_dark_background(im: Image.Image, threshold: int = 40) -> Image.Image:
    rgba = im.convert("RGBA")
    px = rgba.load()
    w, h = rgba.size
    for y in range(h):
        for x in range(w):
            r, g, b, a = px[x, y]
            if a == 0:
                continue
            if _luminance(r, g, b) <= threshold and max(r, g, b) - min(r, g, b) < 24:
                px[x, y] = (r, g, b, 0)
    return rgba


def process_skilledim() -> None:
    src = SOLUTIONS_DIR / "skilledim-logo.png"
    backup = SOLUTIONS_DIR / "skilledim-logo.source.png"
    if not src.exists():
        print(f"Skip: {src} not found")
        return

    if not backup.exists():
        Image.open(src).save(backup, format="PNG")

    if src.exists():
        existing = Image.open(src)
        if existing.size == (TARGET_W, TARGET_H):
            print(f"Skip: {src.name} already {TARGET_W}x{TARGET_H}")
            return

    im = Image.open(backup)
    im = knock_out_dark_background(im)
    out = fit_on_canvas(im, TARGET_W, TARGET_H, PADDING, (255, 255, 255), transparent=True)
    out.save(src, format="PNG", optimize=True)
    print(f"Updated {src.name}: {load_from.stat().st_size} bytes source -> {TARGET_W}x{TARGET_H} canvas")


def process_silver() -> None:
    src = SOLUTIONS_DIR / "silver-accounting-logo.jpeg"
    backup = SOLUTIONS_DIR / "silver-accounting-logo.source.jpeg"
    if not src.exists():
        print(f"Skip: {src} not found")
        return

    # Re-read from backup if re-running so crop stays tight.
    load_from = backup if backup.exists() else src
    if not backup.exists():
        Image.open(src).save(backup, format="JPEG", quality=95)

    im = Image.open(load_from)
    im = flatten_dark_to_white(im, threshold=92)
    out = fit_on_canvas(im, TARGET_W, TARGET_H, PADDING, (255, 255, 255), transparent=False)
    out.save(src, format="JPEG", quality=92, optimize=True)
    print(f"Updated {src.name}: {im.size[0]}x{im.size[1]} source -> {TARGET_W}x{TARGET_H} canvas")


def main() -> int:
    if not SOLUTIONS_DIR.is_dir():
        print(f"Missing directory: {SOLUTIONS_DIR}", file=sys.stderr)
        return 1
    process_skilledim()
    process_silver()
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
