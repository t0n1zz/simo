/**
 * Flatten params.f array to f[0][column]=* style for Laravel GET request.
 * Use when the request is built from dataviewer2's getFilters() (nested f array).
 */
export function flattenFilterParams (p) {
  if (!p || !Array.isArray(p.f) || p.f.length === 0) return p
  const out = { ...p }
  delete out.f
  p.f.forEach((filter, i) => {
    Object.keys(filter).forEach((k) => {
      const v = filter[k]
      if (v !== undefined && v !== null) out[`f[${i}][${k}]`] = v
    })
  })
  return out
}
