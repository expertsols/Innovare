#!/usr/bin/env python3
"""
Crop and resize solution brand logos to fit the aside brand box (360×72).

Run from theme root:
  python scripts/optimize-solution-logos.py

Add logo files under assets/images/solutions/ and extend this script as needed.
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
    min_x, min_y, max_x, max_y = w, h, 0, 0
    found = False
    for y in range(h):
        for x in range(w):
            r, g, b, a = px[x, y]
            if a < 10:
                continue
            if _luminance(r, g, b) <= dark_threshold:
                continue
            found = True
            min_x = min(min_x, x)
            min_y = min(min_y, y)
            max_x = max(max_x, x)
            max_y = max(max_y, y)
    if not found:
        return (0, 0, w, h)
    return (min_x, min_y, max_x + 1, max_y + 1)


def fit_on_canvas(
    im: Image.Image,
    width: int,
    height: int,
    padding: int,
    bg_rgb: tuple[int, int, int],
    transparent: bool = False,
) -> Image.Image:
    bbox = content_bbox(im)
    cropped = im.crop(bbox)
    inner_w = width - 2 * padding
    inner_h = height - 2 * padding
    cropped.thumbnail((inner_w, inner_h), Image.Resampling.LANCZOS)
    mode = "RGBA" if transparent else "RGB"
    canvas = Image.new(mode, (width, height), (0, 0, 0, 0) if transparent else bg_rgb)
    x = (width - cropped.width) // 2
    y = (height - cropped.height) // 2
    if transparent:
        canvas.paste(cropped, (x, y), cropped if cropped.mode == "RGBA" else None)
    else:
        canvas.paste(cropped, (x, y))
    return canvas


def process_logo(filename: str, transparent: bool = True) -> None:
    src = SOLUTIONS_DIR / filename
    if not src.exists():
        print(f"Skip: {src} not found")
        return
    im = Image.open(src)
    out = fit_on_canvas(im, TARGET_W, TARGET_H, PADDING, (255, 255, 255), transparent=transparent)
    fmt = "PNG" if src.suffix.lower() == ".png" else "JPEG"
    out.save(src, format=fmt, optimize=True)
    print(f"Updated {src.name} -> {TARGET_W}x{TARGET_H}")


def main() -> int:
    if not SOLUTIONS_DIR.is_dir():
        print(f"Missing directory: {SOLUTIONS_DIR}", file=sys.stderr)
        return 1
    print("No bundled solution logos to process. Add files under assets/images/solutions/ and call process_logo().")
    return 0


if __name__ == "__main__":
    raise SystemExit(main())
