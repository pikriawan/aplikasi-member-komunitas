const ContentType = {
    Video: {
        value: "video",
        label: "Video",
        variant: "info"
    },
    Ebook: {
        value: "ebook",
        label: "Ebook",
        variant: "warning"
    }
};

ContentType.from = function (value) {
    for (const [k, v] of Object.entries(ContentType)) {
        if (v.value === value) {
            return ContentType[k];
        }
    }

    return null;
};

ContentType.entries = function () {
    return Object.entries(ContentType).filter(([, v]) => typeof v === "object");
}

export default ContentType;
