export const capitalize = str => str.charAt(0).toUpperCase() + str.slice(1)

export const dateToStr = dateStr => {
    const date = new Date(dateStr)
    const options = { day: 'numeric', month: 'long', year: 'numeric' }
    const dateFormatter = new Intl.DateTimeFormat('ru-RU', options)
    const formattedDate = dateFormatter.format(date)
    return formattedDate

}

export const getThumbnailPath = thumbnail => {
    if (thumbnail && (thumbnail.startsWith('http://') || thumbnail.startsWith('https://'))) {
        return thumbnail 
    } else if (thumbnail) {
        return baseURL + '/postimages/' + thumbnail
    } else {
        return 'src/assets/images/thumbnail-default.webp'
    }
}
