import bureauLogo from '@/imports/logo.png'

export function Logo({ size = 'md' }: { size?: 'sm' | 'md' | 'lg' }) {
  const dimensions = {
    sm: { width: 120, height: 42 },
    md: { width: 220, height: 76 },
    lg: { width: 320, height: 110 },
  }[size]

  return (
    <img
      src={bureauLogo}
      alt="Logo"
      width={dimensions.width}
      height={dimensions.height}
      className="object-contain"
      style={{ width: dimensions.width, height: dimensions.height }}
    />
  )
}
