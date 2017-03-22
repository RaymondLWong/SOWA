<xsl:stylesheet version= "1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:output method="text" encoding="UTF-8" media-type="text/plain"/>
<xsl:template match="/">
{
    "listings": [
    <xsl:for-each select="//listings/Property">
        {
            <xsl:apply-templates select="PropertyID" />
            <xsl:apply-templates select="@source" />
            <xsl:apply-templates select="Title" />
            <xsl:apply-templates select="Description" />
            <xsl:apply-templates select="Type" />
            <xsl:apply-templates select="Location" />
            <xsl:apply-templates select="NoOfBeds" />
            <xsl:apply-templates select="CostPerWeek" />
            <xsl:apply-templates select="Address" />
            <xsl:apply-templates select="Email" />
            <xsl:apply-templates select="PictureID" />
        }<xsl:if test="position() != last()">,</xsl:if>
    </xsl:for-each>
    ]
}
</xsl:template>
<xsl:template match="*|@*" >
            "<xsl:value-of select ="name(.)"/>": "<xsl:value-of select="." />"<xsl:if test="name(.) != 'PictureID'">,</xsl:if>
  </xsl:template>
</xsl:stylesheet>
