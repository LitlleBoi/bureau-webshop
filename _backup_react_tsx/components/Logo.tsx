import bureauLogo from '@/imports/image.png'

export function Logo({ size = 'md' }: { size?: 'sm' | 'md' | 'lg' }) {
  const px = { sm: 36, md: 48, lg: 64 }[size]
  return (
    <img
      src={bureauLogo}
      alt="HET BUREAU"
      width={px}
      height={px}
      className="object-contain rounded-lg"
      style={{ width: px, height: px }}
    />
  )
}
