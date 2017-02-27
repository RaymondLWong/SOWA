<?xml version= "1.0" encoding= "UTF-8" ?>
<xsl:stylesheet version= "1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
  <table cellpadding="3">
    <thead><tr>
      <th>PropertyID</th><th>UserID</th><th>CostPerWeek</th><th>Title</th><th>Type</th><th>Description</th><th>Location</th><th>Address</th><th>NoOfBeds</th>
    </tr></thead><tbody>
    <xsl:for-each select="//listings/Properties">
    <xsl:sort order="ascending" select="*" />
      <tr>
        <xsl:apply-templates select="PropertyID" />
        <xsl:apply-templates select="UserID" />
        <xsl:apply-templates select="CostPerWeek" />
        <xsl:apply-templates select="Title" />
        <xsl:apply-templates select="Type" />
        <xsl:apply-templates select="Description" />
        <xsl:apply-templates select="Location" />
        <xsl:apply-templates select="Address" />
        <xsl:apply-templates select="NoOfBeds" />
      </tr>
    </xsl:for-each>
    </tbody>
  </table>
</xsl:template>
<xsl:template match="*" >
  <td> <xsl:value-of select="." /> </td>
  </xsl:template>
</xsl:stylesheet>
