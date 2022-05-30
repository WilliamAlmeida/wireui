import resolveConfig from 'tailwindcss/resolveConfig'
import { TailwindConfig } from 'tailwindcss/tailwind-config'
import tailwindConfig from '@/../tailwind.config.js'
import { Color } from '@/components/color-picker'

export const makeColors = (): Color[] => {
  const config = resolveConfig(tailwindConfig as unknown as TailwindConfig)
  const rawColors = config?.theme?.colors ?? {}

  const colors = Object.entries(rawColors).flatMap(([name, values]) => {
    if (typeof values === 'string') {
      return []
    }

    return Object.entries(values as object).map(([tonality, hex]) => ({
      name: `${name}-${tonality}`,
      value: hex
    }))
  })

  colors.push({ name: 'Black', value: '#000' })
  colors.push({ name: 'White', value: '#fff' })

  return colors
}
