<?xml version= "1.0" encoding= "UTF-8" ?>
<xsl:stylesheet version= "1.0" xmlns:xsl="http://www.w3.org/1999/XSL/Transform">
<xsl:template match="/">
  <table cellpadding="3">
    <thead><tr>
      <th>Title</th>
      <th>Description</th>
      <th>Type</th>
      <th>Location</th>
      <th>NoOfBeds</th>
      <th>CostPerWeek</th>
      <th>Address</th>
      <th>Email</th>
    </tr></thead><tbody>
    <xsl:for-each select="//listings/Property">
    <xsl:sort order="ascending" select="*" />
      <tr>
        <xsl:apply-templates select="Title" />
        <xsl:apply-templates select="Description" />
        <xsl:apply-templates select="Type" />
        <xsl:apply-templates select="Location" />
        <xsl:apply-templates select="NoOfBeds" />
        <xsl:apply-templates select="CostPerWeek" />
        <xsl:apply-templates select="Address" />
        <xsl:apply-templates select="Email" />
      </tr>
    </xsl:for-each>
    </tbody>
  </table>
</xsl:template>
<xsl:template match="*" >
  <td> <xsl:value-of select="." /> </td>
  </xsl:template>
</xsl:stylesheet>
